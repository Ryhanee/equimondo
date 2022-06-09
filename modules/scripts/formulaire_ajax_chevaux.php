<script type="text/javascript">

$('#clients').on('change', function(){
        var clienum = $(this).val();
        console.log(clienum)
        if(clienum){
            $.ajax({
                type:'POST',
                url:'chevClient.php',
                data:{clienum:clienum},
                    success:function(html){
                        $('#cheval').html(html);
                    }
                });
        }
    });
    </script>