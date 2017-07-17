<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>51zx Backend!</title>
    <include file="Common:head_meta" />
    <!--fullCalendar-->
    <link rel="stylesheet" type="text/css" href="http://fex.baidu.com/webuploader/css/webuploader.css">
    <link rel="stylesheet" type="text/css" href="http://fex.baidu.com/webuploader/css/demo.css">
    <!--<link href="__STATIC__/js/webuploader/webuploader.css" rel="stylesheet" type="text/css" media='print' />
    <link href="__STATIC__/js/webuploader/demo.css" rel="stylesheet" type="text/css" />!-->
</head>
<body class="skin-blue">
<input type="checkbox" name="name[]" value="11">
<!-- header logo: style can be found in header.less -->
<include file="Common:head" />
<!-- header end -->
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <include file="Common:left" />
    <!-- Left end -->
    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                蘑菇装修
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php?m=tuangou&c=index&a=index"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="index.php?m=tuangou&c=system&a=index"></i> 系统设置</a></li>
                <li class="active">上传图片</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- form start -->
                <form role="form" id="mogu-index" method="post">
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">上传图片</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">

                                <!--baidu-->
                                <div id="post-container">
                                    <div class="page-container">
                                        <h3 id="demo">图片上传工具</h3>
                                        <p>您可以尝试文件拖拽，使用QQ截屏工具，然后激活窗口后粘贴，或者点击添加图片按钮...</p>
                                        <div id="uploader" class="wu-example">
                                            <div class="queueList">
                                                <div id="dndArea" class="placeholder">
                                                    <div id="filePicker"></div>
                                                    <p>或将照片拖到这里，单次最多可选30张</p>
                                                </div>
                                            </div>
                                            <div class="statusBar" style="display:none;">
                                                <div class="progress">
                                                    <span class="text">0%</span>
                                                    <span class="percentage"></span>
                                                </div>
                                                <div class="info"></div>
                                                <div class="btns">
                                                    <div id="filePicker2"></div>
                                                    <div class="uploadBtn">开始上传</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--baidu-->

                                    <div class="form-group">
                                        <label class="label" for="exampleInputFile">图片地址列表</label>
                                        <textarea class="form-control hide" id="file_names" rows="6" placeholder="请输入描述 ..."></textarea>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- ./left -->

                </form>
            </div><!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->
<!-- add new calendar event modal-->
<include file="Common:foot_meta" />
</body>
<script type="text/javascript" src="/webuploader/jquery.min.js"></script>
<!-- swfupload
<script src="__STATIC__/lte/js/plugins/swfupload/swfupload.js" type="text/javascript"></script>
<script type="text/javascript" src="http://utils.51zx.com/up/js/uploader.js"></script>-->
<script type="text/javascript" src="/webuploader/webuploader.min.js"></script>
<script>
    var BASE_URL   = '/webuploader';
</script>
<script type="text/javascript" src="/webuploader/upload.js"></script>
<script type="text/javascript">
    $(function() {
        /* 这里的每一项的key和城市选择input[type="radio"]的value相同, init是未开通，closed是已满 */
        $('#save-mogu-index').click(function(){
            //$(this).addClass('disabled');
            $.ajax({
                type: "POST",
                url: "index.php?m=tuangou&c=system&a=home&domain=xa",
                data: {
                    'data-json': $("#mogu-index").serializeArray()
                },
                success: function(result){
                    if(result.status == '500') {
                        alert(result.info);
                        $(this).removeClass('disabled');
                        return false;
                    }
                    if(result.status == '200') {
                        alert('保存成功！');
                        setTimeout(function(){
                            window.location.reload();
                        }, 1000)
                        return false;
                    }
                },
                error:function(){
                    alert('系统错误');
                    setTimeout(function(){
                        window.location.reload();
                    }, 1000)
                    return false;
                }
            });
            return false;
        })
    });
</script>
</html>