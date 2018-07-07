$(document).ready(function (){
    $('input[name=user]').on('keyup',function (){
        var user = $(this);
        $.ajax({
            type: 'POST',
            url: 'dashboard/xhrCheckUser',
            data: 'user='+user.val()
        }).done(function(data){
            console.log(data);
            var d = JSON.parse(data);
            if(d.msg!=''){
                $('#ivUser').html(d.msg).addClass('d-block');
                user.addClass('is-invalid');
            } else{
                $('#ivUser').removeClass('d-block');
                user.removeClass('is-invalid');
            }
        });
    });
    $('.frmPass').on('submit',function (e){
        var error = {opass:false, pass:false, rpass:false};
        var opass = $('input[name=oldpass]');
        var pass = $('input[name=pass]');
        var rpass = $('input[name=repass]');
        if(opass.val().length===0){
            error.opass = true;
            opass.addClass('is-invalid');
            $('#ivOpass').html('A régi jelszót ki kell tölteni!').addClass('d-block');
        }
        if(pass.val().length===0){
            error.pass = true;
            pass.addClass('is-invalid');
            $('#ivPass').html('Az új jelszót ki kell tölteni!').addClass('d-block');
        }
        if(rpass.val().length===0){
            error.rpass = true;
            rpass.addClass('is-invalid');
            $('#ivRpass').html('A jelszóismétlést ki kell tölteni!').addClass('d-block');
        }
        if(!error.opass){
            opass.removeClass('is-invalid');
        }
        if(!error.pass){
            opass.removeClass('is-invalid');
        }
        if(!error.rpass){
            opass.removeClass('is-invalid');
        }
        if(error.opass || error.pass || error.rpass){
            e.preventDefault();
        }
    });
});