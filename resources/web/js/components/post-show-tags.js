export function initPostShowTags() {
    document.querySelectorAll('[data-post-tags-toggle]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const tags = trigger.parentElement?.querySelectorAll('.post-show__tag');
            if (!tags?.length) return;

            let hasHiddenTags = false;

            tags.forEach((tag, index) => {
                if (index < 3) return;

                tag.classList.toggle('post-show__tag--hidden');
                hasHiddenTags = hasHiddenTags || tag.classList.contains('post-show__tag--hidden');
            });

            trigger.textContent = hasHiddenTags ? 'Show more' : 'Show less';
        });
    });
}
