/**
 * Projects Swiper Implementation
 * Using Swiper.js for fullscreen project navigation
 */
class ProjectsSwiper {
    constructor() {
        this.projectsSection = null;
        this.swiperContainer = null;
        this.swiper = null;
        this.isActive = false;
        this.originalProjects = [];
        
        this.init();
    }

    init() {
        this.findProjectsSection();
        this.setupScrollListener();
        this.createSwiperStructure();
    }

    findProjectsSection() {
        this.projectsSection = document.querySelector('.latest');
        
        if (!this.projectsSection) {
            console.warn('Projects section (.latest) not found');
            return;
        }
        
        console.log('✅ Projects section found');
    }

    createSwiperStructure() {
        if (!this.projectsSection) return;
        
        // Find all project links and remove duplicates
        const allProjectLinks = this.projectsSection.querySelectorAll('a[href]');
        const uniqueProjects = [];
        const seenHrefs = new Set();
        
        // Filter out duplicate projects
        allProjectLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (!seenHrefs.has(href)) {
                seenHrefs.add(href);
                uniqueProjects.push(link);
            }
        });
        
        // Randomly shuffle the projects
        this.shuffleArray(uniqueProjects);
        this.originalProjects = uniqueProjects;
        
        // Create Swiper container
        this.createSwiperContainer();
        
        console.log('✅ Swiper structure created with random order');
    }
    
    shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

    createSwiperContainer() {
        // Create Swiper container
        this.swiperContainer = document.createElement('div');
        this.swiperContainer.className = 'projects-swiper-container';
        this.swiperContainer.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        `;
        
        // Create Swiper wrapper
        const swiperWrapper = document.createElement('div');
        swiperWrapper.className = 'swiper';
        swiperWrapper.style.cssText = `
            width: 100%;
            height: 100%;
        `;
        
        const swiperWrapperInner = document.createElement('div');
        swiperWrapperInner.className = 'swiper-wrapper';
        
        // Create slides from projects
        this.originalProjects.forEach((link, index) => {
            const slide = document.createElement('div');
            slide.className = 'swiper-slide';
            slide.style.cssText = `
                width: 100vw;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 50px;
                box-sizing: border-box;
                background: ${this.getProjectBackground(index)};
            `;
            
            // Clone the project content
            const clonedLink = link.cloneNode(true);
            clonedLink.style.cssText = `
                width: 80%;
                height: 80%;
                display: block;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 20px 40px rgba(0,0,0,0.3);
                background: white;
                position: relative;
                transition: transform 0.3s ease;
                cursor: pointer;
            `;
            
            // Add hover effects
            clonedLink.addEventListener('mouseenter', () => {
                clonedLink.style.transform = 'scale(1.05)';
            });
            
            clonedLink.addEventListener('mouseleave', () => {
                clonedLink.style.transform = 'scale(1)';
            });
            
            slide.appendChild(clonedLink);
            swiperWrapperInner.appendChild(slide);
        });
        
        // Add navigation arrows
        const prevButton = document.createElement('div');
        prevButton.className = 'swiper-button-prev';
        prevButton.style.cssText = `
            color: white;
            background: rgba(0, 0, 0, 0.5);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            backdrop-filter: blur(10px);
        `;
        
        const nextButton = document.createElement('div');
        nextButton.className = 'swiper-button-next';
        nextButton.style.cssText = `
            color: white;
            background: rgba(0, 0, 0, 0.5);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            backdrop-filter: blur(10px);
        `;
        
        // Add pagination
        const pagination = document.createElement('div');
        pagination.className = 'swiper-pagination';
        pagination.style.cssText = `
            --swiper-pagination-color: white;
            --swiper-pagination-bullet-inactive-color: rgba(255, 255, 255, 0.5);
        `;
        
        // Add close button
        const closeButton = document.createElement('div');
        closeButton.className = 'swiper-close-button';
        closeButton.innerHTML = '✕';
        closeButton.style.cssText = `
            position: absolute;
            top: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            z-index: 1001;
            backdrop-filter: blur(10px);
            transition: background 0.3s ease;
        `;
        
        closeButton.addEventListener('click', () => {
            this.deactivateSwiper();
        });
        
        closeButton.addEventListener('mouseenter', () => {
            closeButton.style.background = 'rgba(255, 0, 0, 0.7)';
        });
        
        closeButton.addEventListener('mouseleave', () => {
            closeButton.style.background = 'rgba(0, 0, 0, 0.7)';
        });
        
        // Assemble the structure
        swiperWrapper.appendChild(swiperWrapperInner);
        swiperWrapper.appendChild(prevButton);
        swiperWrapper.appendChild(nextButton);
        swiperWrapper.appendChild(pagination);
        
        this.swiperContainer.appendChild(swiperWrapper);
        this.swiperContainer.appendChild(closeButton);
        
        document.body.appendChild(this.swiperContainer);
    }
    
    getProjectBackground(index) {
        const backgrounds = [
            'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
            'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
            'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
            'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
            'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)'
        ];
        return backgrounds[index % backgrounds.length];
    }

    setupScrollListener() {
        window.addEventListener('scroll', () => {
            if (!this.projectsSection) return;
            
            const rect = this.projectsSection.getBoundingClientRect();
            const isInProjectsSection = rect.top <= window.innerHeight && rect.bottom >= 0;
            
            if (isInProjectsSection && !this.isActive) {
                this.activateSwiper();
            } else if (!isInProjectsSection && this.isActive) {
                this.deactivateSwiper();
            }
        });
        
        // ESC key to exit
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isActive) {
                this.deactivateSwiper();
            }
        });
    }

    activateSwiper() {
        if (this.isActive || !this.swiperContainer) return;
        
        this.isActive = true;
        console.log('🎯 Swiper mode activated!');
        
        // Hide original projects
        this.projectsSection.style.opacity = '0';
        this.projectsSection.style.pointerEvents = 'none';
        
        // Show swiper container
        this.swiperContainer.style.opacity = '1';
        this.swiperContainer.style.visibility = 'visible';
        
        // Disable body scroll
        document.body.style.overflow = 'hidden';
        
        // Initialize Swiper
        this.swiper = new Swiper('.swiper', {
            direction: 'vertical',
            loop: false,
            speed: 800,
            mousewheel: {
                enabled: true,
                sensitivity: 1,
            },
            keyboard: {
                enabled: true,
                onlyInViewport: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            effect: 'slide',
            allowTouchMove: true,
            grabCursor: true,
            on: {
                slideChange: () => {
                    console.log(`📍 Project ${this.swiper.activeIndex + 1} of ${this.originalProjects.length}`);
                },
                reachEnd: () => {
                    // Allow exit when reaching the end
                    setTimeout(() => {
                        if (this.swiper && this.swiper.isEnd) {
                            console.log('📍 Reached end - ready to exit');
                        }
                    }, 500);
                }
            }
        });
    }

    deactivateSwiper() {
        if (!this.isActive) return;
        
        this.isActive = false;
        console.log('✅ Swiper mode deactivated');
        
        // Destroy swiper instance
        if (this.swiper) {
            this.swiper.destroy(true, true);
            this.swiper = null;
        }
        
        // Hide swiper container
        if (this.swiperContainer) {
            this.swiperContainer.style.opacity = '0';
            this.swiperContainer.style.visibility = 'hidden';
        }
        
        // Show original projects
        this.projectsSection.style.opacity = '';
        this.projectsSection.style.pointerEvents = '';
        
        // Enable body scroll
        document.body.style.overflow = '';
    }
}

// Export for global use
window.ProjectsSwiper = ProjectsSwiper;
