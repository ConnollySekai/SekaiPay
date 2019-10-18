<script defer src="{{ asset('js/jquery.3.4.1.min.js') }}"></script>
<script>
    window.addEventListener('load', function() {
        var script = document.createElement("script");
        script.src = "{{ asset('js/app.js') }}";
        document.body.appendChild(script);
    });
</script>