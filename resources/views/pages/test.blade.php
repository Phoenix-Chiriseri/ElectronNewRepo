<html>
<head><title>Test Page</title></head>
<script src="{{ asset('assets') }}/js/axios.min.js"></script>
<script src="{{ asset('assets') }}/css/jquery-3.3.1.min.js"></script>
<script>
$(document).ready(function(){
    $("#fetchJson").click(function(){
        axios.get("/all-products").then(function(response){
            var myData = response;
            console.log("data is"+myData);
        });
    });
});
</script>
<button id = "fetchJson">Click</button>
</script>
</html>