@extends('admin.master')

@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户中心 <span class="c-gray en">&gt;</span> 用户管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name="">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius">
                    <i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
                <a href="javascript:;" onclick="product_add('添加产品','{{url('/admin/product_add')}}','','510')" class="btn btn-primary radius">
                    <i class="Hui-iconfont">&#xe600;</i> 添加产品</a></span>
            <span class="r">共有数据：<strong>{{count($products)}}</strong> 条</span> </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg">
                <thead>
                <tr class="text-c">
                    <th width="25"><input type="checkbox" name="" id="" value=""></th>
                    <th width="40">ID</th>
                    <th width="100">名称</th>
                    <th width="90">简介</th>
                    <th width="50">价格</th>
                    <th width="50">类别</th>
                    <th width="50">预览图</th>
                    <th width="150">加入时间</th>
                    <th width="130">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr class="text-c">
                        <td><input type="checkbox" value="" name="product_item" id="{{$product->id}}" ></td>
                        <td>{{$product->id}}</td>
                        <td><u style="cursor:pointer" class="text-primary" onclick="product_info('产品详情','{{url('/admin/product_info?id='.$product->id)}}','10001','360','400')">{{$product->name}}</u></td>
                        <td>{{$product->summary}}</td>
                        <td>{{$product->price}}</td>
                        <td>
                            {{$product->category->name}}
                        </td>
                        <td>
                            @if($product->preview != null)
                            {{--<img src="{{$product->preview}}" alt="" style="width: 50px;height: 50px;">--}}
                            <img src="{{url($product->preview)}}" alt="" style="width: 50px;height: 50px;">
                            @endif
                        </td>
                        <td>{{$product->created_at}}</td>
                        <td class="td-manage">
                            <a title="详情" href="javascript:;" onclick="product_info('产品详情','{{url('/admin/product_info?id='.$product->id)}}','','','510')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe685;</i></a>

                            <a title="编辑" href="javascript:;" onclick="product_edit('编辑','{{url('/admin/product_edit?id='.$product->id)}}','','','510')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                            <a title="删除" href="javascript:;" onclick="product_del(this,'{{$product->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                    </tr>

                @endforeach

                </tbody>
            </table>
        </div>
    </div>




{{--
    <!--_footer 作为公共模版分离出去-->
    <script type="text/javascript" src="{{url('/admin/lib/jquery/1.9.1/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/admin/lib/layer/2.4/layer.js')}}"></script>
    <script type="text/javascript" src="{{url('/admin/static/h-ui/js/H-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/admin/static/h-ui.admin/js/H-ui.admin.js')}}"></script>
--}}

    <!--请在下方写此页面业务相关的脚本-->
    <script type="text/javascript" src="{{url('/admin/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script>
    <script type="text/javascript" src="{{url('/admin/lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/admin/lib/laypage/1.2/laypage.js')}}"></script>
    <script type="text/javascript">
    $(function(){
            $('.table-sort').dataTable({
                "aaSorting": [[ 1, "desc" ]],//默认第几个排序
                "bStateSave": true,//状态保存
                "aoColumnDefs": [
                    //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                    {"orderable":false,"aTargets":[0,8,9]}// 制定列不参与排序
                ]
            });

        });
        /*用户-添加*/
        function product_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
        /*用户-查看*/
        function member_show(title,url,id,w,h){
            layer_show(title,url,w,h);
        }
        /*用户-停用*/
        function member_stop(obj,id){
            layer.confirm('确认要停用吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '',
                    dataType: 'json',
                    success: function(data){
                        $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_start(this,id)" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe6e1;</i></a>');
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已停用</span>');
                        $(obj).remove();
                        layer.msg('已停用!',{icon: 5,time:1000});
                    },
                    error:function(data) {
                        console.log(data.msg);
                    },
                });
            });
        }

        /*用户-启用*/
        function member_start(obj,id){
            layer.confirm('确认要启用吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '',
                    dataType: 'json',
                    success: function(data){
                        $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_stop(this,id)" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>');
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
                        $(obj).remove();
                        layer.msg('已启用!',{icon: 6,time:1000});
                    },
                    error:function(data) {
                        console.log(data.msg);
                    },
                });
            });
        }
        /*用户-编辑*/
        function product_edit(title,url,id,w,h){
            layer_show(title,url,w,h);
        }
        /*密码-修改*/
        function change_password(title,url,id,w,h){
            layer_show(title,url,w,h);
        }
        /*用户-删除*/
        function product_del(obj,id){
            alert("{{request()->getBaseUrl()}}");

            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '{{url('/admin/service/product/delete')}}',

                    dataType: 'json',
                    data:{id:id,_token:"{{csrf_token()}}"},
                    success: function(data){
                        if(data == null){
                            layer.msg('服务器错误',{icon:2,time:3000});
                            return;
                        }
                        if(data.status != 0){
                            layer.msg(data.message,{icon:2,time:3000});

                        }
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    },
                    error:function(XmlHttpRequest, textStatus, errorThrown,data) {
                        layer.msg('error!',{icon:2,time:5000});
                        console.log(data.msg);
                        console.log(XmlHttpRequest);
                        console.log(textStatus);
                        console.log(errorThrown);

                    },
                });
            });
        }


    </script>
@stop
@section('my-js')
<script type="text/javascript">
    //判断是否被选中，然后添加或者移除css
    $('input:checkbox[name=product_item]').click(function () {
        var checked = $(this).attr('checked');
        if(checked == 'checked'){
            $(this).attr('checked',false);
//            $(this).next().removeClass('weui_icon_checked');
//            $(this).next().addClass('weui_icon_uncchecked');

        }else{
            $(this).attr('checked' , 'checked');
//            $(this).next().removeClass('weui_icon_unchecked');
//            $(this).next().addClass('weui_icon_checked');
        }
    });
    /*批量-删除*/
    function datadel(){
        var product_ids_arr=[];
        $('input:checkbox[name=product_item]').each(function () {
            if ($(this).attr('checked') == 'checked'){
                product_ids_arr.push($(this).attr('id'));
            }
        });
        layer.confirm('确认要删除吗？',function(index){

            $.ajax({
                type: 'POST',
                url: '{{url('/admin/service/product/items_delete')}}',
                dataType: 'json',
                data:{ids:product_ids_arr+"",_token:"{{csrf_token()}}"},
                success: function(data){
                    if(data == null){
                        layer.msg('服务器错误',{icon:2,time:3000});
                        return;
                    }
                    if(data.status != 0){
                        layer.msg(data.message,{icon:2,time:3000});
                        return;
                    }
                    layer.msg('已删除11!',{icon:1,time:1000});
                    location.reload();
                },
                error:function(XmlHttpRequest, textStatus, errorThrown) {
                    layer.msg('error!',{icon:2,time:5000});
                    console.log(XmlHttpRequest);
                    console.log(textStatus);
                    console.log(errorThrown);

                },
            });
        });

    }
    
    //产品详情
    function product_info(title,url) {
        var index = layer.open({
            type:2,
            title:title,
            content:url
        });
        layer.full(index);
    }


</script>
@stop