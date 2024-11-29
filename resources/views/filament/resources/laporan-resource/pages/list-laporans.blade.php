<script>
    Livewire.on('export-complete', () => {
        location.reload(); 

        const overlay = document.querySelector('.modal-backdrop');
        if (overlay) {
            overlay.remove(); 
        }
    });
</script>
