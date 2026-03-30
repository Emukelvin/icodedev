<?php

namespace App\Http\ViewComposers;

use App\Models\BadgeRead;
use App\Models\BlogComment;
use App\Models\ContactSubmission;
use App\Models\Conversation;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\QuoteRequest;
use App\Models\Task;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SidebarBadgeComposer
{
    public function compose(View $view): void
    {
        if (!Auth::check()) {
            return;
        }

        $user = Auth::user();
        $viewName = $view->getName();

        if (str_contains($viewName, 'admin.partials.sidebar')) {
            $view->with('badges', $this->adminBadges($user));
        } elseif (str_contains($viewName, 'client.partials.sidebar')) {
            $view->with('badges', $this->clientBadges($user));
        } elseif (str_contains($viewName, 'developer.partials.sidebar')) {
            $view->with('badges', $this->developerBadges($user));
        }
    }

    public static function getBadges($user): array
    {
        $role = $user->role;
        if (in_array($role, ['admin', 'manager'])) {
            return (new static)->adminBadges($user);
        }
        if ($role === 'developer') {
            return (new static)->developerBadges($user);
        }
        return (new static)->clientBadges($user);
    }

    private function adminBadges($user): array
    {
        return Cache::remember('sidebar_badges_admin_' . $user->id, 30, function () use ($user) {
            $reads = $this->getUserReads($user->id, [
                'tasks', 'contacts', 'quotes', 'payments', 'invoices', 'comments', 'testimonials'
            ]);

            return [
                'messages'     => $this->unreadMessagesFor($user),
                'tasks'        => $this->countSince(Task::where('status', 'review'), $reads['tasks'], 'updated_at'),
                'contacts'     => $this->countSince(ContactSubmission::where('status', 'new'), $reads['contacts']),
                'quotes'       => $this->countSince(QuoteRequest::where('status', 'new'), $reads['quotes']),
                'payments'     => $this->countSince(Payment::where('status', 'pending'), $reads['payments'], 'updated_at'),
                'invoices'     => $this->countSince(Invoice::whereIn('status', ['overdue', 'pending']), $reads['invoices'], 'updated_at'),
                'comments'     => $this->countSince(BlogComment::where('is_approved', false), $reads['comments']),
                'testimonials' => $this->countSince(Testimonial::where('status', 'pending'), $reads['testimonials']),
            ];
        });
    }

    private function clientBadges($user): array
    {
        return Cache::remember('sidebar_badges_client_' . $user->id, 30, function () use ($user) {
            $reads = $this->getUserReads($user->id, ['payments', 'invoices']);

            return [
                'messages'  => $this->unreadMessagesFor($user),
                'payments'  => $this->countSince(
                    Payment::where('user_id', $user->id)->where('status', 'pending'),
                    $reads['payments'], 'updated_at'
                ),
                'invoices'  => $this->countSince(
                    Invoice::where('user_id', $user->id)->whereIn('status', ['sent', 'overdue']),
                    $reads['invoices'], 'updated_at'
                ),
            ];
        });
    }

    private function developerBadges($user): array
    {
        return Cache::remember('sidebar_badges_developer_' . $user->id, 30, function () use ($user) {
            return [
                'messages' => $this->unreadMessagesFor($user),
            ];
        });
    }

    private function getUserReads(int $userId, array $types): array
    {
        $reads = BadgeRead::where('user_id', $userId)
            ->whereIn('badge_type', $types)
            ->pluck('last_read_at', 'badge_type');

        $result = [];
        foreach ($types as $type) {
            $result[$type] = $reads[$type] ?? null;
        }
        return $result;
    }

    private function countSince($query, $lastRead, string $column = 'created_at'): int
    {
        if ($lastRead) {
            $query->where($column, '>', $lastRead);
        }
        return $query->count();
    }

    private function unreadMessagesFor($user): int
    {
        return Conversation::whereHas('participants', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get()->sum(function ($conversation) use ($user) {
            return $conversation->unreadCountFor($user);
        });
    }

    public static function clearCache(int $userId, ?string $role = null): void
    {
        if ($role === null || in_array($role, ['admin', 'manager'])) {
            Cache::forget('sidebar_badges_admin_' . $userId);
        }
        if ($role === null || $role === 'developer') {
            Cache::forget('sidebar_badges_developer_' . $userId);
        }
        if ($role === null || $role === 'client') {
            Cache::forget('sidebar_badges_client_' . $userId);
        }
    }
}
