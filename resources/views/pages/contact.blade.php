@extends('layouts.app')
@section('title', 'Contact Us - ICodeDev')

@section('content')
<section data-dark-hero class="relative bg-surface-950 text-white overflow-hidden">
    <div class="aurora">
        <div class="aurora-blob w-125 h-125 bg-primary-600/20 top-[-20%] right-[-10%]"></div>
        <div class="aurora-blob w-100 h-100 bg-secondary-500/15 bottom-[-20%] left-[-10%]"></div>
    </div>
    <div class="absolute inset-0 cyber-grid opacity-30 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20 relative">
        <nav class="flex items-center gap-2 text-sm text-gray-400 mb-10 animate-on-scroll">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <i class="fas fa-chevron-right text-[10px] text-gray-600"></i>
            <span class="text-white">Contact</span>
        </nav>
        <div class="max-w-3xl animate-on-scroll">
            <span class="inline-flex items-center gap-2.5 px-5 py-2.5 glass-neon rounded-full text-sm font-medium mb-8"><i class="fas fa-envelope text-primary-400 text-xs"></i> Get In Touch</span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight mb-6">Let's Build <span class="text-shimmer">Together</span></h1>
            <p class="text-lg sm:text-xl text-gray-400 leading-relaxed max-w-2xl">Have a project in mind? Let's discuss how we can bring your idea to life.</p>
        </div>
    </div>
</section>

{{-- Contact Cards --}}
<section class="py-4 -mt-8 relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid sm:grid-cols-3 gap-4">
            @foreach([
                ['icon' => 'envelope', 'bg' => 'from-primary-500/10 to-primary-500/5', 'color' => 'text-primary-600', 'label' => 'Email', 'value' => 'hello@icodedev.com', 'href' => 'mailto:hello@icodedev.com'],
                ['icon' => 'phone', 'bg' => 'from-emerald-500/10 to-emerald-500/5', 'color' => 'text-emerald-600', 'label' => 'Phone', 'value' => '+234 XXX XXX XXXX', 'href' => 'tel:+2347038024207'],
                ['icon' => 'map-marker-alt', 'bg' => 'from-amber-500/10 to-amber-500/5', 'label' => 'Location', 'color' => 'text-amber-600', 'value' => 'Lagos, Nigeria', 'href' => null],
            ] as $info)
            <div class="card-hover p-6 flex items-center gap-4 animate-on-scroll group">
                <div class="w-12 h-12 bg-linear-to-br {{ $info['bg'] }} {{ $info['color'] }} rounded-2xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-500"><i class="fas fa-{{ $info['icon'] }} text-lg"></i></div>
                <div>
                    <p class="text-xs font-bold text-white/40 uppercase tracking-wider">{{ $info['label'] }}</p>
                    @if($info['href'])<a href="{{ $info['href'] }}" class="text-sm font-bold text-white hover:text-primary-400 transition-colors">{{ $info['value'] }}</a>@else<p class="text-sm font-bold text-white">{{ $info['value'] }}</p>@endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-20 lg:py-28 relative">
    <div class="absolute inset-0 cyber-grid opacity-15 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-8 lg:gap-12">
            <div class="md:col-span-1 lg:col-span-2 space-y-6">
                <div class="card-hover p-6 animate-on-scroll">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-5">Quick Connect</h3>
                    <a href="https://wa.me/2347038024207" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 p-4 bg-linear-to-r from-emerald-500/10 to-emerald-500/5 text-emerald-400 rounded-2xl hover:from-emerald-500/15 hover:to-emerald-500/10 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center group-hover:bg-emerald-500/30 group-hover:scale-110 transition-all duration-300"><i class="fab fa-whatsapp text-xl"></i></div>
                        <div><span class="font-semibold text-sm">Chat on WhatsApp</span><p class="text-xs text-emerald-400/70">Usually replies within minutes</p></div>
                    </a>
                </div>
                <div class="card-hover p-6 animate-on-scroll">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-5">Follow Us</h3>
                    <div class="flex gap-2">
                        @foreach([['fab fa-twitter', '#'], ['fab fa-linkedin-in', '#'], ['fab fa-github', '#'], ['fab fa-instagram', '#']] as $social)
                        <a href="{{ $social[1] }}" class="w-11 h-11 bg-white/5 rounded-xl flex items-center justify-center text-white/50 hover:bg-linear-to-br hover:from-primary-500 hover:to-primary-600 hover:text-white hover:shadow-lg hover:shadow-primary-500/25 hover:scale-110 transition-all duration-300"><i class="{{ $social[0] }}"></i></a>
                        @endforeach
                    </div>
                </div>
                <div class="card-hover p-6 animate-on-scroll">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-3">Office Hours</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-white/50">Mon - Fri</span><span class="font-medium text-white">9:00 AM - 6:00 PM</span></div>
                        <div class="flex justify-between"><span class="text-white/50">Saturday</span><span class="font-medium text-white">10:00 AM - 2:00 PM</span></div>
                        <div class="flex justify-between"><span class="text-white/50">Sunday</span><span class="font-medium text-red-400">Closed</span></div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-1 lg:col-span-3">
                <form action="{{ route('contact.submit') }}" method="POST" class="card-hover p-8 lg:p-10 space-y-6 animate-on-scroll">
                    @csrf
                    <div>
                        <h3 class="text-xl font-bold text-white mb-1">Send Us a Message</h3>
                        <p class="text-sm text-white/50">Fill in the details below and we'll get back to you shortly.</p>
                    </div>
                    @if($errors->any())
                    <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm">
                        <ul class="list-disc pl-5 space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                    @endif
                    <div class="grid md:grid-cols-2 gap-5">
                        <div><label class="label">Your Name *</label><input type="text" name="name" required class="input-field" value="{{ old('name') }}"></div>
                        <div><label class="label">Your Email *</label><input type="email" name="email" required class="input-field" value="{{ old('email') }}"></div>
                        <div><label class="label">Phone</label><input type="tel" name="phone" class="input-field" value="{{ old('phone') }}"></div>
                        <div><label class="label">Project Type</label>
                            <select name="project_type" class="input-field">
                                <option value="">Select</option>
                                @foreach($services as $service)<option value="{{ $service->title }}">{{ $service->title }}</option>@endforeach
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div><label class="label">Subject</label><input type="text" name="subject" class="input-field" value="{{ old('subject') }}"></div>
                    <div><label class="label">Message *</label><textarea name="message" rows="5" required class="input-field" placeholder="Tell us about your project...">{{ old('message') }}</textarea></div>
                    <div><label class="label">Estimated Budget ({{ $cs }})</label><input type="number" name="budget" class="input-field" placeholder="Optional" value="{{ old('budget') }}"></div>
                    <div style="position:absolute;left:-9999px;"><input type="text" name="website_url" tabindex="-1" autocomplete="off"></div>
                    @include('partials.recaptcha')
                    <button type="submit" class="btn-primary py-4 w-full text-base magnetic"><i class="fas fa-paper-plane mr-2"></i>Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="h-64 sm:h-80 lg:h-100 bg-surface-900/30 relative">
    <div class="absolute top-0 left-0 right-0 h-12 bg-linear-to-b from-surface-950 to-transparent z-10"></div>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253682.46310593903!2d3.28395955!3d6.548055099999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b8b2ae68280c1%3A0xdc9e87a367c3d9cb!2sLagos!5e0!3m2!1sen!2sng!4v1700000000000" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" class="rounded-none"></iframe>
</section>
@endsection
