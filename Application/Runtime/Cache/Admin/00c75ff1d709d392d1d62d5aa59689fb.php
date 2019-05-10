<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link href="/jwkjw/Public/vendor/bootstrap-table/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/jwkjw/Public/vendor/switchery/switchery.css" rel="stylesheet">
    <link href="/jwkjw/Public/vendor/chosen/chosen.css" rel="stylesheet">

    <link href="/jwkjw/Public/vendor/bootstrap-table/bootstrap-table/src/bootstrap-table.css" rel="stylesheet">
    <link href="/jwkjw/Public/css/style.css?v=4.0.0" rel="stylesheet">

    <script src="/jwkjw/Public/vendor/bootstrap-table/jquery.min.js"></script>
    <script src="/jwkjw/Public/vendor/bootstrap-table/bootstrap/js/bootstrap.min.js"></script>

    <script src="/jwkjw/Public/vendor/switchery/switchery.js"></script>
    <script src="/jwkjw/Public/vendor/chosen/chosen.jquery.js"></script>
    <script src="/jwkjw/Public/vendor/chosen/chosen.order.jquery.js"></script>
    <script src="/jwkjw/Public/vendor/chosen-ajax-addition/chosen.ajaxaddition.jquery.js"></script>

    <script src="/jwkjw/Public/vendor/bootstrap-table/bootstrap-table/src/bootstrap-table.js"></script>
    <script src="/jwkjw/Public/vendor/bootstrap-table/bootstrap-table/src/locale/bootstrap-table-zh-CN.js"></script>
    <script type="text/javascript" src="/jwkjw/Public/vendor/layui/layui.js"></script>
    <link href="/jwkjw/Public/css/tablepublic.css" rel="stylesheet">

    <style>
        th {
            text-align: center;
        }

        .tablelist2 {
            width: 500px;
        }
        .form-control {
            margin-top: 50px;
            display: inline-block;
            width: 250px;
        }

        .z-tab {
            margin-left: 40%;
            margin-top: 50px;
            display: inline-block;
        }

        .z-tab button {
            margin: 10px;
            display: inline-block;
        }
        .control-label{
            font-size: 18px;
        }
    </style>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins">
        <div class="ibox-content">

            <div class="row row-lg">
                <div class="col-sm-12">
                    <div>
                        <p class="name" style="text-align: center;font-size: 30px;">模块授权</p>
                    </div>
                    <div class="_box" style="margin-top: -5px;">
                        <label id="search_lable" class="control-label" style="margin-left:15px;width: 70px">角色:</label>
                        <input type="text" class="form-control" placeholder="" id="search_realname"
                               style="width:200px;display: inline-block;">

                        <!--<a class="btn btn-warning " style="margin-left: 10px;" type="button" id="sys_add" ><i class="fa fa-sign-out"></i>&nbsp;添加</a>-->
                        <button class="btn btn-info" style="margin-left: 10px;" type="button" id="sys_refresh">查询</button>
                        <button class="btn btn-danger" style="margin-left: 10px;" type="button" id="sys_export">导出</button>
                        <!--
                        <button class="btn btn-error" style="margin-left: 10px;" type="button" id="sys_del"><i
                                class="fa fa-eraser"></i>&nbsp;删除
                        </button>-->
                    </div>
                    <div class="z-tab" style="display: inline-block;position: absolute;top:5px;">
                        <button class="btn btn-info tab" style="width: 150px;margin-left: 0px;color: black"
                                type="button">角色授权
                        </button>
                        <button class="btn btn-info tab" style="width: 150px;margin-left: -4px;color: black"
                                type="button">模块授权
                        </button>
                    </div>
                    <div id="box1">
                        <table id="atpbiztable"></table>
                    </div>
                    <div id="box2" style="display:none">
                        <table id="atpbiztable2" ></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="sys_dlg" role="dialog" class="modal fade "></div>
<input type="hidden" id="sort">
<input type="hidden" id="sortOrder">
<input type="hidden" id="sort2">
<input type="hidden" id="sortOrder2">
<div class="modal fade" id="loading" role="dialog" data-backdrop='static'>
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">处理中</h4>
            </div>
            <div class="modal-body">
                <img src="/jwkjw/Public/img/loading/loading9.gif" style='display: block;margin: 0 auto'>
                <div id="loadingText" style="text-align: center"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/jwkjw/Public/vendor/layui/layui.js"></script>
<script type="text/javascript" src="/jwkjw/Public/js/banBackSpace.js"></script>

<script>
    layui.use('layer', function () {
        layer = layui.layer;
    })
    $('.tab').eq(0).css('background', '#2e63c2');
    $('.tab').eq(0).css('color', '#fff');
    $('.tab').eq(0).siblings().css('background', '#fff');
    $('.tab').eq(0).siblings().css('color', 'black');
    $('.tab').on('click', function () {
        $(this).css('background', '#2e63c2');
        $(this).css('color', '#fff');
        $(this).siblings().css('background', '#fff');
        $(this).siblings().css('color', 'black');
        var index = $(this).index();
        if (index == 1) {
            $('#search_lable').text("模块:");
            $('#box2').show();
            $('#box1').hide();
        } else {
            $('#search_lable').text("角色:");
            $('#box2').hide();
            $('#box1').show();
        }
    });
    $(function () {
        $('#atpbiztable').bootstrapTable({
            url: '/jwkjw/index.php/RoleAuth/getDataByRole',         //请求后台的URL（*）
            method: 'post',                      //请求方式（*）
            toolbar: '#atpbiztoolbar',                //工具按钮用哪个容器
            striped: true,                      //是否显示行间隔色
            cache: false,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
            pagination: true,                   //是否显示分页（*）
            iconSize: 'outline',
            sortable: true,                     //是否启用排序
            sortName: "role_name",
            sortOrder: "asc",                   //排序方式
            queryParams: queryParams,//传递参数（*）
            sidePagination: "server",           //分页方式：client客户端分页，server服务端分页（*）
            pageNumber: 1,                       //初始化加载第一页，默认第一页
            pageSize: 10,                       //每页的记录行数（*）
            pageList: [5, 10, 25, 50, 100],        //可供选择的每页的行数（*）
//            strictSearch: true,
//            showColumns: true,                  //是否显示所有的列
//            showRefresh: true,                  //是否显示刷新按钮
            minimumCountColumns: 2,             //最少允许的列数
            clickToSelect: true,                //是否启用点击选中行
//            height: 600,                        //行高，如果没有设置height属性，表格自动根据记录条数觉得表格高度
            uniqueId: "role_id",                     //每一行的唯一标识，一般为主键列
//            showToggle: true,                    //是否显示详细视图和列表视图的切换按钮
//            cardView: true,                    //是否显示详细视图
            detailView: false,                   //是否显示父子表
            columns: [[
                {checkbox: true},
                {
                    title: '序号', width: 40,
                    formatter: function (value, row, index) {
                        var option = $('#atpbiztable').bootstrapTable("getOptions");
                        return option.pageSize * (option.pageNumber - 1) + index + 1;
                    }
                },
                {field: 'role_name', title: '角色', sortable: true, width: 150},
                {field: 'models', title: '模块', sortable: false, width: 150},
                {
                    field: 'role_id', title: '操作', sortable: false, width: 60,
                    formatter: function (value, row, index) {
                        var inp = "'" + value + "'";
                        var a = '<a  class="btn btn-info btn-xs" onclick="updateRoleInRow(' + inp + ')">编辑</a><br>';
                        return a;
                    }
                }
            ]
            ],
            onDblClickRow: function (row) {
                layer.open({
                    title: '模块列表',
                    closeBtn: 1,
                    type: 2,
                    shadeClose: false,
                    content: '/jwkjw/index.php/RoleAuth/editByRole?roleid=' + row['role_id'],
                    area: ['800px', '400px']
                });
            },
            onSort: function (name, order) {
            }
        });
        $('#atpbiztable2').bootstrapTable({
            url: '/jwkjw/index.php/RoleAuth/getDataByModel',         //请求后台的URL（*）
            method: 'post',                      //请求方式（*）
            toolbar: '#atpbiztoolbar',                //工具按钮用哪个容器
            striped: true,                      //是否显示行间隔色
            cache: false,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
            pagination: true,                   //是否显示分页（*）
            iconSize: 'outline',
            sortable: true,                     //是否启用排序
            sortName: "mi_name",
            sortOrder: "asc",                   //排序方式
            queryParams: queryParams2,//传递参数（*）
            sidePagination: "server",           //分页方式：client客户端分页，server服务端分页（*）
            pageNumber: 1,                       //初始化加载第一页，默认第一页
            pageSize: 10,                       //每页的记录行数（*）
            pageList: [5, 10, 25, 50, 100],        //可供选择的每页的行数（*）
//            strictSearch: true,
//            showColumns: true,                  //是否显示所有的列
//            showRefresh: true,                  //是否显示刷新按钮
            minimumCountColumns: 2,             //最少允许的列数
            clickToSelect: true,                //是否启用点击选中行
//            height: 600,                        //行高，如果没有设置height属性，表格自动根据记录条数觉得表格高度
            uniqueId: "mi_id",                     //每一行的唯一标识，一般为主键列
//            showToggle: true,                    //是否显示详细视图和列表视图的切换按钮
//            cardView: true,                    //是否显示详细视图
            detailView: false,                   //是否显示父子表
            columns: [[
                {checkbox: true},
                {
                    title: '序号', width: 40,
                    formatter: function (value, row, index) {
                        var option = $('#atpbiztable2').bootstrapTable("getOptions");
                        return option.pageSize * (option.pageNumber - 1) + index + 1;
                    }
                },
                {field: 'mi_name', title: '模块', sortable: true, width: 150},
                {field: 'roles', title: '角色', sortable: false, width: 150},
                {
                    field: 'mi_id', title: '操作', sortable: false, width: 60,
                    formatter: function (value, row, index) {
                        var inp = "'" + value + "'";
                        var a = '<a  class="btn btn-info btn-xs" onclick="updateModelInRow(' + inp + ')">编辑</a><br>';
                        return a;
                    }
                }
            ]
            ],
            onDblClickRow: function (row) {
                layer.open({
                    title:'角色列表',
                    closeBtn:1,
                    type: 2,
                    shadeClose:false,
                    content: '/jwkjw/index.php/RoleAuth/editByModel?modelid=' + row['mi_id'],
                    area: ['800px', '380px']
                });
            },
            onSort: function (name, order) {
            }
        });
    })
    function queryParams(params) {  //配置参数
        $('#sort').val(params.sort);
        $('#sortOrder').val(params.order);
        var temp = {   //这里的键的名字和控制器的变量名必须一直，这边改动，控制器也需要改成一样的
            limit: params.limit,   //页面大小
            offset: params.offset,  //页码
            sort: params.sort,  //排序列名
            sortOrder: params.order,//排位命令（desc，asc）
            real_name: $('#search_realname').val(),
        };
        return temp;
    }
    function queryParams2(params) {  //配置参数
        $('#sort2').val(params.sort);
        $('#sortOrder2').val(params.order);
        var temp = {   //这里的键的名字和控制器的变量名必须一直，这边改动，控制器也需要改成一样的
            limit: params.limit,   //页面大小
            offset: params.offset,  //页码
            sort: params.sort,  //排序列名
            sortOrder: params.order,//排位命令（desc，asc）
            real_name: $('#search_realname').val(),
        };
        return temp;
    }
    $('#sys_refresh').on('click', function () {
        if ($('#search_lable').text() === '角色:') {
            $('#atpbiztable').bootstrapTable('refresh')
        }
        else {
            $('#atpbiztable2').bootstrapTable('refresh')
        }
    });
    $('#sys_export').on('click', function () {
        $('#loading').modal('show');
        var sort=$('#sort').val();
        var sortOrder=$('#sortOrder').val();
        var sort2=$('#sort2').val();
        var sortOrder2=$('#sortOrder2').val();
        var real_name=$('#search_realname').val();
        if ($('#search_lable').text() === '角色:') {
            var t = "/jwkjw/index.php/RoleAuth/exportByRole?sort="+sort+"&sortOrder="+sortOrder+"&real_name="+real_name;
            t = encodeURI(t);
            $.ajax({
                type:'get',
                url: t,
                dataType:'json',
                success:function(data){
                    $('#loading').modal('hide');
                    if(data.code > 0){
                        location.href = data.message;
                    }else{
                        layer.msg(data.message);
                    }
                }
            })
        }
        else {
            var t = "/jwkjw/index.php/RoleAuth/exportByModel?sort="+sort2+"&sortOrder="+sortOrder2+"&real_name="+real_name;
            t = encodeURI(t);
            $.ajax({
                type:'get',
                url: t,
                dataType:'json',
                success:function(data){
                    $('#loading').modal('hide');
                    if(data.code > 0){
                        location.href = data.message;
                    }else{
                        layer.msg(data.message);
                    }
                }
            })
        }
    });
    function updateRoleInRow(id) {
        layer.open({
            title: '模块列表',
            closeBtn: 1,
            type: 2,
            shadeClose: false,
            content: '/jwkjw/index.php/RoleAuth/editByRole?roleid=' + id,
            area: ['800px', '380px']
        });
    }
    function updateModelInRow(id) {
        layer.open({
            title: '角色列表',
            closeBtn: 1,
            type: 2,
            shadeClose: false,
            content: '/jwkjw/index.php/RoleAuth/editByModel?modelid=' + id,
            area: ['800px', '370px']
        });
    }
</script>
</body>
</html>