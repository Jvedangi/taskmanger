document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.delete-attachment');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const attachmentId = this.dataset.id;
            if (!confirm('Are you sure you want to delete this attachment?')) return;

            fetch(`/attachments/${attachmentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const li = document.getElementById('attachment-' + attachmentId);
                    li.remove(); // remove from DOM
                } else {
                    alert('Error deleting attachment');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Something went wrong');
            });
        });
    });
});
