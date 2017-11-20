        </div>
    </body>

    <script>
        $(function () {

            $(".nav-item").click(function(){
                $(".nav-item").removeClass('active');
                $(this).addClass('active');
            });

          $('[data-toggle="tooltip"]').tooltip()

        })
    </script>
</html>