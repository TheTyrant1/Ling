export function initComments() {
    document.addEventListener('click', (event) => {
        // Toggle reply form
        const toggleReplyBtn = event.target.closest('[data-comment-toggle-reply]');
        if (toggleReplyBtn) {
            const formId = toggleReplyBtn.getAttribute('data-comment-toggle-reply');
            const el = document.getElementById(formId);
            if (el) {
                el.classList.toggle('comment-node--hidden');
            }
            return;
        }

        // Toggle replies list
        const toggleRepliesBtn = event.target.closest('[data-comment-toggle-replies]');
        if (toggleRepliesBtn) {
            const parentId = toggleRepliesBtn.getAttribute('data-comment-toggle-replies');
            const group = document.getElementById('replies-group-' + parentId);
            const btn = document.getElementById('view-btn-' + parentId);

            if (group && btn) {
                if (group.classList.contains('comment-node--hidden')) {
                    group.classList.remove('comment-node--hidden');
                    btn.innerHTML = '—— Hide replies';
                } else {
                    group.classList.add('comment-node--hidden');
                    const count = group.querySelectorAll(':scope > .comment-node--reply').length;
                    btn.innerHTML = `—— View replies (${count})`;
                }
            }
            return;
        }

        // Load more replies
        const loadMoreBtn = event.target.closest('[data-comment-load-more]');
        if (loadMoreBtn) {
            const parentId = loadMoreBtn.getAttribute('data-comment-load-more');
            const container = document.getElementById('replies-group-' + parentId);
            if (container) {
                const hiddenReplies = container.querySelectorAll(':scope > .comment-node--hidden-reply.comment-node--hidden');

                for (let i = 0; i < 3; i++) {
                    if (hiddenReplies[i]) {
                        hiddenReplies[i].classList.remove('comment-node--hidden');
                    }
                }

                const remainingHidden = container.querySelectorAll(':scope > .comment-node--hidden-reply.comment-node--hidden').length;
                if (remainingHidden === 0) {
                    loadMoreBtn.style.display = 'none';
                }
            }
            return;
        }

        // Toggle read more/less for comments
        const readMoreBtn = event.target.closest('[data-comment-read-more]');
        if (readMoreBtn) {
            const commentId = readMoreBtn.getAttribute('data-comment-read-more');
            const shortText = document.getElementById('comment-short-' + commentId);
            const fullText = document.getElementById('comment-full-' + commentId);
            if (shortText && fullText) {
                shortText.classList.toggle('comment-node--hidden');
                fullText.classList.toggle('comment-node--hidden');
                readMoreBtn.innerHTML = readMoreBtn.innerHTML.trim() === 'Read more' ? 'Show less' : 'Read more';
            }
            return;
        }

        // Trigger auth modal
        const authTrigger = event.target.closest('[data-auth-trigger], [data-auth-required]');
        if (authTrigger) {
            event.preventDefault();
            if (typeof window.showAuthModal === 'function') {
                window.showAuthModal();
            }
            return;
        }
    });
}
