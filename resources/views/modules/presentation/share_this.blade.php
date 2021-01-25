@php

@endphp

<div class="share-box">
    <span>SHARE THIS</span>
    <a href="https://www.twitter.com/share?url={{ url()->current() }}"><i class="fab fa-twitter"></i></a>
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"><i class="fab fa-facebook-f"></i></a>
    <div class="stat"><span></span></div>
</div>
<script>
    $(function() {
        
        var token = '195555885641080|581cf3b5b528066ccfef093e8e3aafec', // learn how to obtain it above
        url = 'https://www.islamichelp.org.uk/';
        
        $.ajax({
            url: 'https://graph.facebook.com/v3.0/',
            dataType: 'jsonp',
            type: 'GET',
            data: {
                fields: 'engagement', 
                access_token: token, 
                id: url},
            success: function(data){
                console.log(data);
                $('div.stat span').text(data.engagement.share_count);
            },
            error: function(data){
                console.log(data); // send the error notifications to console
            }
        });

    });
</script>