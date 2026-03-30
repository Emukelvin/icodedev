import './bootstrap';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);
window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {

    // ═══════════════════════════════════════════════════════════════
    // CUSTOM CURSOR - Glowing cursor that follows mouse (desktop only)
    // ═══════════════════════════════════════════════════════════════
    if (window.innerWidth > 768 && !('ontouchstart' in window)) {
        const cursorGlow = document.createElement('div');
        cursorGlow.className = 'cursor-glow';
        const cursorDot = document.createElement('div');
        cursorDot.className = 'cursor-dot';
        document.body.appendChild(cursorGlow);
        document.body.appendChild(cursorDot);

        let cx = 0, cy = 0, dx = 0, dy = 0;
        document.addEventListener('mousemove', e => { cx = e.clientX; cy = e.clientY; });

        const animateCursor = () => {
            dx += (cx - dx) * 0.15;
            dy += (cy - dy) * 0.15;
            cursorGlow.style.left = dx - 10 + 'px';
            cursorGlow.style.top = dy - 10 + 'px';
            cursorDot.style.left = cx - 3 + 'px';
            cursorDot.style.top = cy - 3 + 'px';
            requestAnimationFrame(animateCursor);
        };
        animateCursor();

        // Expand cursor on interactive elements
        document.querySelectorAll('a, button, [role="button"], input, textarea, select, .card-hover, .tilt-card').forEach(el => {
            el.addEventListener('mouseenter', () => {
                cursorGlow.style.transform = 'scale(2.5)';
                cursorGlow.style.borderColor = 'rgba(99,102,241,0.8)';
                cursorGlow.style.background = 'rgba(99,102,241,0.05)';
            });
            el.addEventListener('mouseleave', () => {
                cursorGlow.style.transform = 'scale(1)';
                cursorGlow.style.borderColor = 'rgba(99,102,241,0.5)';
                cursorGlow.style.background = 'transparent';
            });
        });
    }

    // ═══════════════════════════════════════════════════════════════
    // SCROLL PROGRESS BAR - Top gradient bar
    // ═══════════════════════════════════════════════════════════════
    const progressBar = document.getElementById('scroll-progress');
    if (progressBar) {
        window.addEventListener('scroll', () => {
            const scrolled = window.scrollY / (document.documentElement.scrollHeight - window.innerHeight);
            progressBar.style.transform = `scaleX(${Math.min(scrolled, 1)})`;
        }, { passive: true });
    }

    // ═══════════════════════════════════════════════════════════════
    // PARTICLE SYSTEM - Floating particles on dark hero sections
    // ═══════════════════════════════════════════════════════════════
    const particleCanvas = document.getElementById('particle-canvas');
    if (particleCanvas) {
        const ctx = particleCanvas.getContext('2d');
        let particles = [];
        const resize = () => { particleCanvas.width = window.innerWidth; particleCanvas.height = window.innerHeight; };
        resize();
        window.addEventListener('resize', resize);

        class Particle {
            constructor() { this.reset(); }
            reset() {
                this.x = Math.random() * particleCanvas.width;
                this.y = Math.random() * particleCanvas.height;
                this.size = Math.random() * 2 + 0.5;
                this.speedX = (Math.random() - 0.5) * 0.5;
                this.speedY = (Math.random() - 0.5) * 0.5;
                this.opacity = Math.random() * 0.5 + 0.1;
                this.color = ['99,102,241', '6,182,212', '236,72,153'][Math.floor(Math.random() * 3)];
            }
            update() {
                this.x += this.speedX;
                this.y += this.speedY;
                if (this.x < 0 || this.x > particleCanvas.width) this.speedX *= -1;
                if (this.y < 0 || this.y > particleCanvas.height) this.speedY *= -1;
            }
            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(${this.color},${this.opacity})`;
                ctx.fill();
            }
        }

        for (let i = 0; i < 30; i++) particles.push(new Particle());

        const drawLines = () => {
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const dist = Math.sqrt(dx * dx + dy * dy);
                    if (dist < 100) {
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.strokeStyle = `rgba(99,102,241,${0.08 * (1 - dist / 120)})`;
                        ctx.lineWidth = 0.5;
                        ctx.stroke();
                    }
                }
            }
        };

        const animateParticles = () => {
            ctx.clearRect(0, 0, particleCanvas.width, particleCanvas.height);
            particles.forEach(p => { p.update(); p.draw(); });
            drawLines();
            requestAnimationFrame(animateParticles);
        };
        animateParticles();
    }

    // ═══════════════════════════════════════════════════════════════
    // SCROLL-AWARE NAVIGATION - Glass morphism on scroll
    // ═══════════════════════════════════════════════════════════════
    const nav = document.getElementById('main-nav');
    if (nav) {
        const updateNav = () => {
            const scrollY = window.scrollY;

            if (scrollY > 60) {
                nav.classList.add('bg-surface-900/90', 'backdrop-blur-2xl', 'shadow-lg', 'shadow-black/20', 'border-b', 'border-white/10');
                nav.querySelectorAll('.nav-link:not(.nav-link-active)').forEach(l => {
                    l.classList.add('text-white/70'); l.classList.remove('text-white/80');
                });
                nav.querySelectorAll('.nav-link-active').forEach(l => {
                    l.classList.add('text-primary-400'); l.classList.remove('text-white');
                    l.querySelector('.nav-active-dot')?.classList.add('bg-primary-400');
                    l.querySelector('.nav-active-dot')?.classList.remove('bg-white');
                });
            } else {
                nav.classList.remove('bg-surface-900/90', 'backdrop-blur-2xl', 'shadow-lg', 'shadow-black/20', 'border-b', 'border-white/10');
                nav.querySelectorAll('.nav-link:not(.nav-link-active)').forEach(l => {
                    l.classList.remove('text-white/70'); l.classList.add('text-white/80');
                });
                nav.querySelectorAll('.nav-link-active').forEach(l => {
                    l.classList.remove('text-primary-400'); l.classList.add('text-white');
                    l.querySelector('.nav-active-dot')?.classList.remove('bg-primary-400');
                    l.querySelector('.nav-active-dot')?.classList.add('bg-white');
                });
            }
        };
        window.addEventListener('scroll', updateNav, { passive: true });
        updateNav();
    }

    // ═══════════════════════════════════════════════════════════════
    // MOBILE MENU - Smooth toggle
    // ═══════════════════════════════════════════════════════════════
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', () => {
            const isOpen = !mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden');
            mobileToggle.querySelector('.hamburger-icon')?.classList.toggle('open', !isOpen);
        });
    }

    // ═══════════════════════════════════════════════════════════════
    // SIDEBAR TOGGLE - Dashboard
    // ═══════════════════════════════════════════════════════════════
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    if (sidebarToggle && sidebar) {
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay?.classList.toggle('hidden');
        };
        sidebarToggle.addEventListener('click', toggleSidebar);
        overlay?.addEventListener('click', toggleSidebar);
    }

    // ═══════════════════════════════════════════════════════════════
    // FLASH MESSAGES - Auto-dismiss with slide out
    // ═══════════════════════════════════════════════════════════════
    document.querySelectorAll('[data-dismiss]').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'all 0.5s cubic-bezier(0.16,1,0.3,1)';
            el.style.opacity = '0';
            el.style.transform = 'translateX(120px) scale(0.95)';
            setTimeout(() => el.remove(), 500);
        }, 5000);
        el.querySelector('[data-close]')?.addEventListener('click', () => {
            el.style.transition = 'all 0.3s cubic-bezier(0.16,1,0.3,1)';
            el.style.opacity = '0';
            el.style.transform = 'translateX(120px) scale(0.95)';
            setTimeout(() => el.remove(), 300);
        });
    });

    // ═══════════════════════════════════════════════════════════════
    // SCROLL ANIMATIONS - Staggered reveal with multiple animation types
    // ═══════════════════════════════════════════════════════════════
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const delay = parseInt(el.dataset.delay || '0');
                const type = el.dataset.animate || 'up';

                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0) translateX(0) scale(1)';
                }, delay);
                observer.unobserve(el);
            }
        });
    }, { threshold: 0.06, rootMargin: '0px 0px -60px 0px' });

    document.querySelectorAll('.animate-on-scroll').forEach((el, index) => {
        const type = el.dataset.animate || 'up';
        el.style.opacity = '0';
        el.style.transition = 'opacity 0.6s cubic-bezier(0.16,1,0.3,1), transform 0.6s cubic-bezier(0.16,1,0.3,1)';

        if (type === 'up') el.style.transform = 'translateY(30px)';
        else if (type === 'left') el.style.transform = 'translateX(-30px)';
        else if (type === 'right') el.style.transform = 'translateX(30px)';
        else if (type === 'scale') el.style.transform = 'scale(0.95)';
        else el.style.transform = 'translateY(30px)';

        if (!el.dataset.delay) el.dataset.delay = (index % 6) * 80;
        observer.observe(el);
    });

    // ═══════════════════════════════════════════════════════════════
    // COUNTER ANIMATION - Smooth number counting with easing
    // ═══════════════════════════════════════════════════════════════
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.dataset.counter);
                const duration = 2500;
                const start = performance.now();
                const animate = (now) => {
                    const progress = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 4);
                    el.textContent = Math.floor(target * eased).toLocaleString();
                    if (progress < 1) requestAnimationFrame(animate);
                };
                requestAnimationFrame(animate);
                counterObserver.unobserve(el);
            }
        });
    }, { threshold: 0.5 });
    document.querySelectorAll('[data-counter]').forEach(el => counterObserver.observe(el));

    // ═══════════════════════════════════════════════════════════════
    // TILT EFFECT - 3D card tilt on mouse move
    // ═══════════════════════════════════════════════════════════════
    document.querySelectorAll('.tilt-card').forEach(card => {
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = ((y - centerY) / centerY) * -6;
            const rotateY = ((x - centerX) / centerX) * 6;
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale(1)';
        });
        card.style.transition = 'transform 0.3s ease';
    });

    // ═══════════════════════════════════════════════════════════════
    // MAGNETIC BUTTONS - Subtle pull toward cursor
    // ═══════════════════════════════════════════════════════════════
    document.querySelectorAll('.magnetic').forEach(el => {
        el.addEventListener('mousemove', e => {
            const rect = el.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            el.style.transform = `translate(${x * 0.3}px, ${y * 0.3}px)`;
        });
        el.addEventListener('mouseleave', () => {
            el.style.transform = 'translate(0, 0)';
        });
    });

    // ═══════════════════════════════════════════════════════════════
    // PARALLAX - Multi-layer parallax on scroll
    // ═══════════════════════════════════════════════════════════════
    const parallaxElements = document.querySelectorAll('[data-parallax]');
    if (parallaxElements.length > 0) {
        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY;
            parallaxElements.forEach(el => {
                const speed = parseFloat(el.dataset.parallax) || 0.5;
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    el.style.transform = `translateY(${scrollY * speed * 0.1}px)`;
                }
            });
        }, { passive: true });
    }

    // ═══════════════════════════════════════════════════════════════
    // TYPING EFFECT - Terminal-style typing
    // ═══════════════════════════════════════════════════════════════
    const typeElements = document.querySelectorAll('[data-type]');
    typeElements.forEach(el => {
        const text = el.dataset.type;
        const speed = parseInt(el.dataset.typeSpeed) || 50;
        el.textContent = '';
        let i = 0;
        const typeObserver = new IntersectionObserver(entries => {
            if (entries[0].isIntersecting) {
                const type = () => {
                    if (i < text.length) {
                        el.textContent += text.charAt(i);
                        i++;
                        setTimeout(type, speed);
                    }
                };
                type();
                typeObserver.unobserve(el);
            }
        }, { threshold: 0.5 });
        typeObserver.observe(el);
    });

    // ═══════════════════════════════════════════════════════════════
    // TESTIMONIALS SLIDER - Auto-play with smooth transitions
    // ═══════════════════════════════════════════════════════════════
    const slider = document.getElementById('testimonial-slider');
    if (slider) {
        const slides = slider.querySelectorAll('.testimonial-slide');
        let current = 0;
        const show = (i) => {
            slides.forEach(s => { s.classList.add('hidden'); s.style.opacity = '0'; s.style.transform = 'translateX(20px)'; });
            slides[i]?.classList.remove('hidden');
            requestAnimationFrame(() => {
                slides[i].style.transition = 'all 0.7s cubic-bezier(0.16,1,0.3,1)';
                slides[i].style.opacity = '1';
                slides[i].style.transform = 'translateX(0)';
            });
        };
        show(0);
        setInterval(() => { current = (current + 1) % slides.length; show(current); }, 6000);
    }

    // ═══════════════════════════════════════════════════════════════
    // TAB SWITCHING - Smooth animated tabs
    // ═══════════════════════════════════════════════════════════════
    document.querySelectorAll('[data-tab-target]').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.tabTarget;
            const group = btn.closest('[data-tab-group]');
            if (!group) return;
            group.querySelectorAll('[data-tab-target]').forEach(b => {
                b.classList.remove('border-primary-600', 'text-primary-600', 'bg-primary-50');
                b.classList.add('border-transparent', 'text-gray-500');
            });
            btn.classList.add('border-primary-600', 'text-primary-600', 'bg-primary-50');
            btn.classList.remove('border-transparent', 'text-gray-500');
            group.querySelectorAll('[data-tab-panel]').forEach(p => {
                p.classList.add('hidden');
                p.style.opacity = '0';
            });
            const panel = group.querySelector(`[data-tab-panel="${target}"]`);
            if (panel) {
                panel.classList.remove('hidden');
                requestAnimationFrame(() => {
                    panel.style.transition = 'opacity 0.4s ease';
                    panel.style.opacity = '1';
                });
            }
        });
    });

    // ═══════════════════════════════════════════════════════════════
    // PORTFOLIO FILTER - Smooth filter transitions
    // ═══════════════════════════════════════════════════════════════
    document.querySelectorAll('[data-filter]').forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.dataset.filter;
            document.querySelectorAll('[data-filter]').forEach(b => {
                b.classList.remove('bg-primary-600', 'text-white', 'shadow-lg', 'shadow-primary-500/30');
                b.classList.add('bg-white/80', 'text-gray-600', 'border', 'border-gray-200/50');
            });
            btn.classList.add('bg-primary-600', 'text-white', 'shadow-lg', 'shadow-primary-500/30');
            btn.classList.remove('bg-white/80', 'text-gray-600', 'border', 'border-gray-200/50');
            document.querySelectorAll('[data-category]').forEach(item => {
                const show = filter === 'all' || item.dataset.category === filter;
                item.style.transition = 'all 0.5s cubic-bezier(0.16,1,0.3,1)';
                if (show) {
                    item.style.display = '';
                    requestAnimationFrame(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1) translateY(0)';
                    });
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.9) translateY(10px)';
                    setTimeout(() => { item.style.display = 'none'; }, 500);
                }
            });
        });
    });

    // ═══════════════════════════════════════════════════════════════
    // INVOICE ITEMS - Dynamic invoice form
    // ═══════════════════════════════════════════════════════════════
    const addItemBtn = document.getElementById('add-invoice-item');
    if (addItemBtn) {
        let itemCount = document.querySelectorAll('.invoice-item').length;
        addItemBtn.addEventListener('click', () => {
            const template = document.getElementById('invoice-item-template');
            if (!template) return;
            const clone = template.content.cloneNode(true);
            clone.querySelectorAll('[name]').forEach(el => {
                el.name = el.name.replace('__INDEX__', itemCount);
            });
            document.getElementById('invoice-items-container').appendChild(clone);
            itemCount++;
        });
    }

    // ═══════════════════════════════════════════════════════════════
    // DROPDOWN TOGGLE - Click-to-toggle dropdowns
    // ═══════════════════════════════════════════════════════════════
    document.querySelectorAll('[data-dropdown]').forEach(trigger => {
        const target = document.getElementById(trigger.dataset.dropdown);
        if (!target) return;
        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            const isHidden = target.classList.contains('hidden');
            document.querySelectorAll('[id$="-dropdown"]').forEach(d => d.classList.add('hidden'));
            if (isHidden) {
                target.classList.remove('hidden');
                target.style.animation = 'fadeInUp 0.2s ease forwards';
            }
        });
        document.addEventListener('click', () => target.classList.add('hidden'));
    });

    // ═══════════════════════════════════════════════════════════════
    // SMOOTH SCROLL - For anchor links
    // ═══════════════════════════════════════════════════════════════
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            const target = document.querySelector(anchor.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ═══════════════════════════════════════════════════════════════
    // RIPPLE EFFECT - Material-style ripple on buttons
    // ═══════════════════════════════════════════════════════════════
    document.querySelectorAll('.btn-primary, .btn-dark, .btn-neon').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            ripple.style.cssText = `
                position:absolute; border-radius:50%; pointer-events:none;
                width:${size}px; height:${size}px;
                left:${e.clientX - rect.left - size/2}px;
                top:${e.clientY - rect.top - size/2}px;
                background:rgba(255,255,255,0.3);
                transform:scale(0); animation:ripple 0.6s ease-out;
            `;
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Add ripple keyframes
    const style = document.createElement('style');
    style.textContent = '@keyframes ripple { to { transform: scale(4); opacity: 0; }}';
    document.head.appendChild(style);

    // ═══════════════════════════════════════════════════════════════
    // SMOOTH NUMBER REVEAL - For stats with + suffix
    // ═══════════════════════════════════════════════════════════════
    document.querySelectorAll('[data-count-suffix]').forEach(el => {
        const suffix = el.dataset.countSuffix;
        const counterEl = el.querySelector('[data-counter]');
        if (counterEl) {
            const orig = counterEl.dataset.counter;
            const mo = new MutationObserver(() => {
                if (counterEl.textContent === parseInt(orig).toLocaleString()) {
                    counterEl.textContent += suffix;
                    mo.disconnect();
                }
            });
            mo.observe(counterEl, { childList: true, characterData: true, subtree: true });
        }
    });
});

