document.addEventListener('DOMContentLoaded', () => {
    // Mobile drawer / menu toggles with aria-expanded + Escape key restoration
    document.querySelectorAll('[data-menu-toggle]').forEach((toggle) => {
        const targetId = toggle.getAttribute('aria-controls');
        if (!targetId) {
            return;
        }
        const menu = document.getElementById(targetId);
        if (!menu) {
            return;
        }

        const closeMenu = () => {
            menu.hidden = true;
            toggle.setAttribute('aria-expanded', 'false');
        };

        const openMenu = () => {
            menu.hidden = false;
            toggle.setAttribute('aria-expanded', 'true');
        };

        toggle.addEventListener('click', () => {
            const isOpen = toggle.getAttribute('aria-expanded') === 'true';
            if (isOpen) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
                closeMenu();
                toggle.focus();
            }
        });
    });

    // Accessible password visibility toggle (modern-web-guidance: forms)
    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        const inputId = button.getAttribute('data-password-toggle');
        const input = inputId ? document.getElementById(inputId) : null;
        if (!input) {
            return;
        }

        button.addEventListener('click', () => {
            const isPressed = button.getAttribute('aria-pressed') === 'true';
            input.type = isPressed ? 'password' : 'text';
            button.setAttribute('aria-pressed', String(!isPressed));
            button.textContent = isPressed ? 'Tampilkan' : 'Sembunyikan';
        });
    });

    // Double-submit guard on forms once valid submission starts
    document.querySelectorAll('form[data-prevent-double-submit]').forEach((form) => {
        form.addEventListener('submit', () => {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton instanceof HTMLButtonElement) {
                submitButton.disabled = true;
                submitButton.dataset.originalText = submitButton.textContent ?? '';
                submitButton.textContent = 'Menyimpan...';
            }
        });
    });

    // Delete confirmation buttons without inline onclick attributes (CSP friendly)
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            const message = form.getAttribute('data-confirm') || 'Yakin ingin menghapus data ini?';
            if (!window.confirm(message)) {
                event.preventDefault();
            }
        });
    });

    // Photo thumbnail switcher on motorcycle detail page
    const mainPhoto = document.getElementById('detail-main-photo');
    if (mainPhoto instanceof HTMLImageElement) {
        document.querySelectorAll('[data-gallery-thumb]').forEach((button) => {
            button.addEventListener('click', () => {
                const src = button.getAttribute('data-gallery-thumb');
                if (!src) {
                    return;
                }
                mainPhoto.src = src;
                document.querySelectorAll('[data-gallery-thumb]').forEach((item) => {
                    item.setAttribute('aria-pressed', 'false');
                    item.classList.remove('border-brand', 'ring-2', 'ring-brand/20');
                    item.classList.add('border-line');
                });
                button.setAttribute('aria-pressed', 'true');
                button.classList.add('border-brand', 'ring-2', 'ring-brand/20');
                button.classList.remove('border-line');
            });
        });
    }

    // Live image preview on Owner motorcycle photo input
    const photoInput = document.getElementById('photo');
    const previewBox = document.getElementById('photo-preview-box');
    const previewImg = document.getElementById('photo-preview-img');
    if (
        photoInput instanceof HTMLInputElement &&
        previewBox instanceof HTMLElement &&
        previewImg instanceof HTMLImageElement
    ) {
        photoInput.addEventListener('change', () => {
            const file = photoInput.files?.[0];
            if (!file) {
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                if (typeof e.target?.result === 'string') {
                    previewImg.src = e.target.result;
                    previewBox.hidden = false;
                }
            };
            reader.readAsDataURL(file);
        });
    }
});