<div>
    <script type="text/javascript">
        window.addEventListener('showToast', event => {
            // console.log(event);
            Toastify({
                text: event.detail[0],
                className: `px-5 py-4 text-xs text-white font-bold fixed mt-16 rounded-lg mx-4  bg-${event.detail[1]} z-50`,
                position: "right",
                stopOnFocus: true,
                duration: 3000
            }).showToast();
        })
    </script>
</div>
