@extends('crudbooster::admin_template')
@section('content')
    <script src="../InteMall/js/jquery-3.3.1.min.js"></script>
    <h4>上传广告图片：</h4>
    <form id="form1" style="width:100%;height:auto;border:1px solid red;padding:30px 50px;margin-bottom:15px;">
        广告一：<img src="{{$banner1->banner_path}}" id="img1" style="width:150px;height:auto;display:inline;padding-right:10px;">
        <input name="banner_id" type="hidden" value="{{$banner1->banner_id}}"/>
        <input name="banner1_path" type="hidden" value="{{$banner1->banner_path}}"/>
        <input name="banner1" type="file" style="display:inline;width:200px;"/>
        <input name="banner1_url" type="text" value="{{$banner1->banner_url}}" style="display:inline;width:400px;margin-left:100px;" placeholder="请输入http://开头链接网址"/>
        <input type="button" value="上传" style="display:inline;float:right" onclick="submit1()"/>
    </form>
    <form id="form2" style="width:100%;height:auto;border:1px solid red;padding:30px 50px;margin-bottom:15px;">
        广告二：<img src="{{$banner2->banner_path}}" id="img2" style="width:150px;height:auto;display:inline;padding-right:10px;">
        <input name="banner_id" type="hidden" value="{{$banner2->banner_id}}"/>
        <input name="banner2_path" type="hidden" value="{{$banner2->banner_path}}"/>
        <input name="banner2" type="file" style="display:inline;width:200px;"/>
        <input name="banner2_url" type="text" value="{{$banner2->banner_url}}" style="display:inline;width:400px;margin-left:100px;" placeholder="请输入http://开头链接网址"/>
        <input type="button" value="上传" style="display:inline;float:right" onclick="submit2()"/>
    </form>
    <form id="form3" style="width:100%;height:auto;border:1px solid red;padding:30px 50px;margin-bottom:15px;">
        广告三：<img src="{{$banner3->banner_path}}" id="img3" style="width:150px;height:auto;display:inline;padding-right:10px;">
        <input name="banner_id" type="hidden" value="{{$banner3->banner_id}}"/>
        <input name="banner3_path" type="hidden" value="{{$banner3->banner_path}}"/>
        <input name="banner3" type="file" style="display:inline;width:200px;"/>
        <input name="banner3_url" type="text" value="{{$banner3->banner_url}}" style="display:inline;width:400px;margin-left:100px;" placeholder="请输入http://开头链接网址"/>
        <input type="button" value="上传" style="display:inline;float:right" onclick="submit3()"/>
    </form>
    <script type="text/javaScript">
        function submit1(){
            var form1 = document.getElementById("form1");
            var formData = new FormData(form1);
            $.ajax({
                url:"{{action('InteBannerController@upload1')}}",
                data:formData,
                type:"POST",
                dataType:"json",
                contentType: false,
                processData: false,
                mimeType: "multipart/form-data",
                success:function(res){
                    $('#img1').attr('src',res.banner_path);
                    $("input[name='banner1_path']").val(res.banner_path);
                    $("input[name='banner1_url']").val(res.banner_url);
                }
            });
        }
        function submit2(){
            var form2 = document.getElementById("form2");
            var formData = new FormData(form2);
            $.ajax({
                url:"{{action('InteBannerController@upload2')}}",
                data:formData,
                type:"POST",
                dataType:"json",
                contentType: false,
                processData: false,
                mimeType: "multipart/form-data",
                success:function(res){
                    $('#img2').attr('src',res.banner_path);
                    $("input[name='banner2_path']").val(res.banner_path);
                    $("input[name='banner2_url']").val(res.banner_url);
                }
            });
        }
        function submit3(){
            var form3 = document.getElementById("form3");
            var formData = new FormData(form3);
            $.ajax({
                url:"{{action('InteBannerController@upload3')}}",
                data:formData,
                type:"POST",
                dataType:"json",
                contentType: false,
                processData: false,
                mimeType: "multipart/form-data",
                success:function(res){
                    $('#img3').attr('src',res.banner_path);
                    $("input[name='banner3_path']").val(res.banner_path);
                    $("input[name='banner3_url']").val(res.banner_url);
                }
            });
        }
    </script>
@endsection
