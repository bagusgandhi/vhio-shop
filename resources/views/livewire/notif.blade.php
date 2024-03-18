<div>
    <script type="text/javascript">
        window.addEventListener('showToast', event => {
            // console.log(event);
            Toastify({
                text: event.detail[0],
                className: 'font-bold mt-16 rounded-lg z-50',
                position: "center",
                stopOnFocus: true,
                duration: 3000,
                style: {
                    background: event.detail[1] == "success" ? "green" : "red",
                },
            }).showToast();
        })
    </script>
</div>
