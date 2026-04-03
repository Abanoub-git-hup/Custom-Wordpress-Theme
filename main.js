/**
 * Abanoub Portfolio - Core Animation Engine
 * المهندس: أبانوب موريس
 * الهدف: الربط بين GSAP و ScrollTrigger لتحقيق تجربة مستخدم سلسة
 */

(function() {
    'use strict';

    // [1] تسجيل المكتبات: لازم نعرف GSAP إننا هنستخدم إضافة ScrollTrigger
    if (typeof gsap !== "undefined") {
        gsap.registerPlugin(ScrollTrigger);
        
        // تحسين الأداء: السطر ده بيقلل عدد مرات الحسابات اللي ScrollTrigger بيعملها في الثانية
        ScrollTrigger.config({ limitCallbacks: true });
        
        // للموبايل: بيخلي السكرول أنعم وبيحل مشاكل الـ Address Bar اللي بيختفي ويظهر
        if (window.innerWidth <= 768) {
            ScrollTrigger.normalizeScroll(true);
        }
    }

    /**
     * [SECTION 1] Typing Effect (تأثير الكتابة)
     * الوظيفة: تبديل النصوص في الهيرو سيكشن بشكل آلي
     */
    const typingConfig = {
        elementId: 'dynamic-text',
        words: ['WordPress Developer', 'Frontend Architect', 'UI/UX Enthusiast'],
        typeSpeed: 150,        // سرعة كتابة الحرف (بالملي ثانية)
        eraseSpeed: 70,       // سرعة مسح الحرف
        delayBetweenWords: 2000 // مدة الانتظار بعد اكتمال الكلمة
    };

    let wordIndex = 0, charIndex = 0, isDeleting = false;

    function handleTyping() {
        const target = document.getElementById(typingConfig.elementId);
        if (!target) return;

        const currentWord = typingConfig.words[wordIndex];
        
        // منطق القطع: بياخد جزء من الكلمة بناءً على مكان الـ index الحالي
        target.textContent = isDeleting 
            ? currentWord.substring(0, charIndex - 1) 
            : currentWord.substring(0, charIndex + 1);

        charIndex = isDeleting ? charIndex - 1 : charIndex + 1;

        // تحديد سرعة الخطوة الجاية: لو بيمسح بيبقى أسرع
        let nextStepSpeed = isDeleting ? typingConfig.eraseSpeed : typingConfig.typeSpeed;

        // حالة اكتمال الكلمة: استنى شوية وابدأ امسح
        if (!isDeleting && charIndex === currentWord.length) {
            nextStepSpeed = typingConfig.delayBetweenWords;
            isDeleting = true;
        } 
        // حالة المسح الكامل: انقل على الكلمة اللي بعدها
        else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            wordIndex = (wordIndex + 1) % typingConfig.words.length;
            nextStepSpeed = 500;
        }

        setTimeout(handleTyping, nextStepSpeed);
    }

    /**
     * [SECTION 2] Header Scripts (تحويل الهيدر عند السكرول)
     */
    function initHeaderScripts() {
        // أنميشن الدخول (أول ما الموقع يفتح)
        const headerTl = gsap.timeline({ defaults: { ease: "power4.out", duration: 1 } });
        headerTl
            .to(".logo-link", { y: 0, opacity: 1, delay: 0.5 })
            .to(".nav-menu", { scale: 1, opacity: 1, duration: 0.8 }, "-=0.6")
            .to(".social-icon", { y: 0, opacity: 1, stagger: 0.1 }, "-=0.5");

        // تغيير شكل الهيدر بمجرد ما تنزل 50 بكسل
        gsap.to(".main-header", {
            scrollTrigger: {
                trigger: "body",
                start: "top -50", 
                toggleActions: "play none none reverse", // العب الأنميشن وأنت نازل، واعكسه وأنت طالع
            },
            backgroundColor: "rgba(3, 7, 12, 0.95)", // خلفية شفافة غامقة
            backdropFilter: "blur(15px)",           // تأثير زجاجي (تقيل شوية على الأداء)
            height: "70px",                         // تصغير الارتفاع لتوفير مساحة
            duration: 0.4
        });
    }

   /**
     * [SECTION 3] Hero Section (أنميشن البداية والكروت الطائرة)
     * تم التعديل: الأنميشن يعمل فقط على الشاشات الأكبر من 768px
     */
    function initHeroScripts() {
        let mm = gsap.matchMedia();

        // تشغيل الأنميشن فقط إذا كانت الشاشة أكبر من 768 بكسل
        mm.add("(min-width: 769px)", () => {
            
            // 1. أنميشن ظهور صورة البروفايل (تأثير المسح)
            gsap.from(".profile-img", {
                clipPath: "inset(100% 0% 0% 0%)", 
                duration: 0.5,
                ease: "power4.inOut",
                delay: 0.5
            });

            // 2. ظهور عناصر النصوص واحد ورا التاني
            gsap.from(".hero-content > *", {
                y: 30,
                opacity: 0,
                duration: 1,
                stagger: 0.2,
                ease: "power3.out",
                delay: 1
            });

            // 3. تأثير الطفو للكروت (Floating)
            gsap.to(".floating-card", {
                y: i => (i % 2 === 0 ? 15 : -15),
                duration: 3,
                ease: "sine.inOut",
                yoyo: true,
                repeat: -1,
                stagger: 0.5
            });
        });

        // حالة الموبايل: ظهور بسيط للعناصر بدون أنميشن حركة معقد
        mm.add("(max-width: 768px)", () => {
            // هنا بنخلي العناصر تظهر ثابتة وبسيطة عشان ميبقاش فيه تقطيع
            gsap.set(".profile-img", { clipPath: "inset(0% 0% 0% 0%)", opacity: 1 });
            gsap.from(".hero-content > *", {
                opacity: 0,
                y: 10,
                duration: 0.8,
                stagger: 0.1
            });
            // الكروت الطائرة هتفضل ثابتة في مكانها الـ CSS الطبيعي
            gsap.set(".floating-card", { y: 0 });
        });
    }

    /**
     * [SECTION 4] Portfolio (Stacking Cards Effect)
     * القيمة: ده السيكشن الأهم، بيخلي المشاريع تثبت فوق بعضها
     */
    function initPortfolioScripts() {
        const cards = gsap.utils.toArray('.project-card.stack-card');
        
        cards.forEach((card, i) => {
            // أ - التثبيت (Pinning): بيخلي الكارت "يلزق" في الشاشة
            ScrollTrigger.create({
                trigger: card,
                start: "top 10%",           // يبدأ يثبت لما الكارت يبعد عن فوق بـ 10%
                endTrigger: cards[i + 1] ? cards[i + 1] : card, // ينتهي لما اللي بعده يوصل له
                end: "top 10%",
                pin: true,                  // السطر السحري للتثبيت
                pinSpacing: false,          // مهم جداً: بيخلي الكروت تطلع فوق بعضها مش تزق بعض
                scrub: true,                // يخلي الحركة مرتبطة بسرعة السكرول
                refreshPriority: 1          // بيجبر GSAP يحسب الأماكن بدقة في حالة وجود كروت كتير
            });

            // ب - التلاشي (Scale & Darken): بيدي عمق للمشروع اللي "بيتغطى"
            if (i !== cards.length - 1) { // بنطبق ده على كل الكروت ماعدا الأخير
                gsap.to(card, {
                    scale: 0.92,             // يصغر شوية كأنه بيبعد لورا
                    filter: "brightness(0.5)", // يظلم عشان يركز العين على المشروع الجديد (0.5 = 50% سطوع)
                    scrollTrigger: {
                        trigger: card,
                        start: "top 10%",
                        endTrigger: cards[i + 1],
                        end: "top 10%",
                        scrub: true
                    }
                });
            }
        });
    }

    /**
     * [INIT] تشغيل الماكينة
     */
    function startEverything() {
        handleTyping();       // ابدأ تأثير الكتابة
        initHeaderScripts();  // شغل أنميشن الهيدر
        initHeroScripts();    // شغل أنميشن الهيرو
        initPortfolioScripts(); // شغل تأثير المشاريع الـ Stacking
        
        // استدعاء الفانكشنز التانية لو موجودة
        if (typeof initSkillsScripts === "function") initSkillsScripts();
        if (typeof initResumeScripts === "function") initResumeScripts();
    }

    // التأكد إن الموقع حمل بالكامل قبل البدء عشان المسافات تتحسب صح
    window.addEventListener('load', startEverything);

})();