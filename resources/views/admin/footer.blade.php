

    <!-- START SCRIPTS-->
    <script type="text/javascript" src="{{ URL::to('/admin') }}/js/plugins/jquery/jquery.min.js"></script>
    <script src="{{ URL::to('/admin') }}/js/plugins/jquery/jquery-ui.min.js" type="text/javascript"></script>


    <script src="{{ URL::to('/admin') }}/js/jtable.2.4.0/jquery.jtable.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{ URL::to('/admin') }}/js/plugins/bootstrap/bootstrap.min.js"></script>





    <script type="text/javascript" src="{{ URL::to('/admin') }}/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>





    <script type="text/javascript" src="{{ URL::to('/admin') }}/js/script.js"></script>
    <script type="text/javascript" src="{{ URL::to('/admin') }}/js/plugins.js"></script>
    <script type="text/javascript" src="{{ URL::to('/admin') }}/js/actions.js"></script>









    <!-- ================================================ -->

    <script type="text/javascript">

        $(document).ready(function(){
            $('button.ui-dialog-titlebar-close').html('X');
        });

        $('#viewCommentTableContainer').jtable(
            {
                title: 'User Feedback Table',
                paging: true, //Enable paging
                pageSize: 10, //Set page size (default: 10)
                sorting: true, //Enable sorting
                defaultSorting: 'Name ASC', //Set default sorting
                actions:
                {
                    listAction: function (postData, jtParams)
                    {
                        console.log("Loading from custom function...");
                        return $.Deferred(function ($dfd)
                        {
                            $.ajax({
                                url: 'ajax/view-comment-ajax.php?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                                type: 'POST',
                                dataType: 'json',
                                data: postData,
                                success: function (data)
                                {
                                    $dfd.resolve(data);
                                },
                                error: function ()
                                {
                                    $dfd.reject();
                                }
                            });
                        });
                    },
                    // createAction: 'ajax/view-comment-ajax.php?action=create',
                    // updateAction: 'ajax/view-comment-ajax.php?action=update',
                    deleteAction: 'ajax/view-comment-ajax.php?action=delete'
                },
                fields: {
                    id: {
                        key: true,
                        list: false,
                        title: 'id',
                    },
                    fname: {
                        title: 'Firstname',
                        width: '15%'
                    },
                    lname: {
                        title: 'Lastname',
                        width: '15%'
                    },
                    email: {
                        title: 'E-Mail',
                        width: '30%'
                    },
                    message: {
                        title: 'message',
                        width: '40%',
                        sorting: false,
                    },
                }

        });


        $('#viewCommentTableContainer').jtable('load');



        $('#storeTableContainer').jtable(
        {
            title: 'Stores Table',


            formCreated: function (event, data)
            {
                data.form.attr('enctype','multipart/form-data');

            },
            formSubmitting: function(event, data)
            {
                //filename = $('input[type=file]').val().split('\\').pop();
                //alert(filename);
                //alert($("#" + data.form.attr("id")).find('input[name="image"]').val(filename));

            },
            paging: true, //Enable paging
            pageSize: 10, //Set page size (default: 10)
            sorting: true, //Enable sorting
            defaultSorting: 'Name ASC', //Set default sorting
            actions:
            {
                //listAction: 'ajax/category-ajax.php?action=list',
                listAction: function (postData, jtParams)
                {
                    console.log("Loading from custom function...");
                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/stores-ajax.php?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            type: 'POST',
                            dataType: 'json',
                            data: postData,
                            success: function (data)
                            {
                                $dfd.resolve(data);
                            },
                            error: function ()
                            {
                                $dfd.reject();
                            }
                        });
                    });
                },

                //createAction: 'ajax/store-ajax.php?action=create',
                createAction: function (postData)
                {
                    var formData = getVars(postData);

                    if($('#storeimg_upload').val() !== "")
                    {
                        formData.append("storeimg", $('#storeimg_upload').get(0).files[0]);
                    }

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/stores-ajax.php?action=create',
                            //url: 'ajax/store-ajax.php?action=create&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            processData: false, // Don't process the files
                            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                            success: function (data)
                            {
                                $dfd.resolve(data);
                                $('#table-container').jtable('load');
                            },
                            error: function ()
                            {
                                $dfd.reject();
                            }
                        });
                    });
                },

                //updateAction: 'ajax/store-ajax.php?action=update',
                updateAction: function (postData)
                {
                    var formData = getVars(postData);

                    if($('#storeimg_upload').val() !== "")
                    {
                        formData.append("storeimg_update", $('#storeimg_upload').get(0).files[0]);
                    }

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/stores-ajax.php?action=update',
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            processData: false, // Don't process the files
                            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                            success: function (data)
                            {
                                $dfd.resolve(data);
                                $('#table-container').jtable('load');
                            },
                            error: function () {
                                $dfd.reject();
                            }
                        });
                    });
                },
                deleteAction: 'ajax/stores-ajax.php?action=delete'
            },
            fields:
            {
                store_id: {
                    key: true,
                    list: false,
                    title: 'id',
                },
                name: {
                    title: 'Store Name',
                },
                description:
                {
                    list: true,
                    title: 'Store Description',width: '50%',sorting: false,
                    input: function (data)
                    {
                        if (data.record)
                        {
                            return '<textarea cols="50" id="descriptionText" name="descriptionText" rows="4" wrap="hard">' + data.record.description+ '</textarea>';
                        }
                        else
                        {
                            return '<textarea cols="50" id="descriptionText" name="descriptionText" rows="4" wrap="hard" />';
                        }
                    },
                    display:function(data)
                    {
                        return data.record.description.substring(0,200);
                    }
                },
                image:
                {
                    list: true,
                    title: 'Store Logo',
                    type:'file',sorting: false,
                    display: function(data)
                    {
                        return '<img src="' + data.record.image +  '" width="150" height="150" class="preview">';
                    },
                    input: function (data)
                    {
                        //console.log(data.record.store_id);
                        if (data.record)
                        {
                            markup = (      '<div id="preview_' + data.record.store_id + '">'+
                                                '<img src="' + data.record.image +  '" width="150" height="150" class="preview" id="storeimg">'+
                                            '</div>' +
                                            '<br/><br/><input type="file" accept="image/*" name="imgupload" id="storeimg_upload" data-storeid="' + data.record.store_id + '"/ >');
                            return markup;
                        }
                        else
                        {
                            markup = (      '<div id="preview_0">'+
                                                '<img src="" width="150" height="150" class="preview" id="storeimg">'+
                                            '</div>' +
                                            '<br/><br/><input type="file" accept="image/*" id="storeimg_upload" data-storeid="0" name="imgupload"/ >');
                            return markup;
                        }
                    }


                },
                open:{list: true,title: 'Open', sorting: false},
                close:{list: true,title: 'Close',sorting: false},

           }
        });


        $('#storeTableContainer').jtable('load');


    $(document).on('change','#storeimg_upload', function()
    {
        console.log(this);
        console.log($(this));
        var id=this.id;
        var storeid = $(this).data('storeid');


        //alert(storeid);
        readURL(this,storeid);


    });



    function readURL(input,storeid)
    {

        if (input.files && input.files[0])
        {
            var reader = new FileReader();

            reader.onload = function (e)
            {
                $('#preview_' + storeid  + '> img').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }


    // Read a page's GET URL variables and return them as an associative array.
    function getVars(url)
    {
        var formData = new FormData();
        var split;
        $.each(url.split("&"), function(key, value)
        {
            split = value.split("=");
            formData.append(split[0], decodeURIComponent(split[1].replace(/\+/g, " ")));
        });

        return formData;
    }


    /*
    if (typeof categoryArrayobj === "undefined")
    {
        categoryArrayobj ={};
    }
    if (typeof storeArrayobj === "undefined")
    {
        storeArrayobj ={};
    }

    $(document).ready(function ()
    {

        $('#deliveryGridTableContainer').jtable(
        {
            title: 'Delivery Grid Table',
            paging: true, //Enable paging
            pageSize: 10, //Set page size (default: 10)
            sorting: true, //Enable sorting
            defaultSorting: 'Name ASC', //Set default sorting
            actions:
            {
                listAction: function (postData, jtParams)
                {
                    console.log("Loading from custom function...");
                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/datagrid-ajax.php?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            type: 'POST',
                            dataType: 'json',
                            data: postData,
                            success: function (data)
                            {
                                $dfd.resolve(data);
                            },
                            error: function ()
                            {
                                $dfd.reject();
                            }
                        });
                    });
                },
                createAction: 'ajax/datagrid-ajax.php?action=create',
                updateAction: 'ajax/datagrid-ajax.php?action=update',
                deleteAction: 'ajax/datagrid-ajax.php?action=delete'
            },
            fields: {
                deliverygrid_id: {
                    key: true,
                    list: false,
                    title: 'id',
                },
                area: {
                    title: 'Express Grid',
                    width: '40%'
                },
                price: {
                    title: 'Pickup & Delivery Fee (Rs)',
                    width: '20%'
                }
            }

        });


        $('#deliveryGridTableContainer').jtable('load');

        $('#categoryTableContainer').jtable(
        {
            title: 'Product Category Table',
            paging: true, //Enable paging
            pageSize: 10, //Set page size (default: 10)
            sorting: true, //Enable sorting
            defaultSorting: 'Name ASC', //Set default sorting
            actions:
            {
                listAction: function (postData, jtParams)
                {
                    console.log("Loading from custom function...");
                    return $.Deferred(function ($dfd)
                    {
                        $.ajax(
                        {
                            url: 'ajax/category-ajax.php?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            type: 'POST',
                            dataType: 'json',
                            data: postData,
                            success: function (data)
                            {
                                $dfd.resolve(data);
                            },
                            error: function ()
                            {
                                $dfd.reject();
                            }
                        });
                    });
                },
                createAction: 'ajax/category-ajax.php?action=create',
                updateAction: 'ajax/category-ajax.php?action=update',
                deleteAction: 'ajax/category-ajax.php?action=delete'
            },
            fields: {
                category_id: {
                    key: true,
                    list: false,
                    title: 'id',
                },
                category: {
                    title: 'Product Categories',
                    width: '40%'
                }
            }

        });

        $('#categoryTableContainer').jtable('load');



        $('#storeTableContainer').jtable(
        {
            title: 'Stores Table',


            formCreated: function (event, data)
            {
                data.form.attr('enctype','multipart/form-data');

            },
            formSubmitting: function(event, data)
            {
                //filename = $('input[type=file]').val().split('\\').pop();
                //alert(filename);
                //alert($("#" + data.form.attr("id")).find('input[name="image"]').val(filename));

            },
            paging: true, //Enable paging
            pageSize: 10, //Set page size (default: 10)
            sorting: true, //Enable sorting
            defaultSorting: 'Name ASC', //Set default sorting
            actions:
            {
                //listAction: 'ajax/category-ajax.php?action=list',
                listAction: function (postData, jtParams)
                {
                    console.log("Loading from custom function...");
                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/stores-ajax.php?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            type: 'POST',
                            dataType: 'json',
                            data: postData,
                            success: function (data)
                            {
                                $dfd.resolve(data);
                            },
                            error: function ()
                            {
                                $dfd.reject();
                            }
                        });
                    });
                },

                //createAction: 'ajax/store-ajax.php?action=create',
                createAction: function (postData)
                {
                    var formData = getVars(postData);

                    if($('#storeimg_upload').val() !== "")
                    {
                        formData.append("storeimg", $('#storeimg_upload').get(0).files[0]);
                    }

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/stores-ajax.php?action=create',
                            //url: 'ajax/store-ajax.php?action=create&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            processData: false, // Don't process the files
                            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                            success: function (data)
                            {
                                $dfd.resolve(data);
                                $('#table-container').jtable('load');
                            },
                            error: function ()
                            {
                                $dfd.reject();
                            }
                        });
                    });
                },

                //updateAction: 'ajax/store-ajax.php?action=update',
                updateAction: function (postData)
                {
                    var formData = getVars(postData);

                    if($('#storeimg_upload').val() !== "")
                    {
                        formData.append("storeimg_update", $('#storeimg_upload').get(0).files[0]);
                    }

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/stores-ajax.php?action=update',
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            processData: false, // Don't process the files
                            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                            success: function (data)
                            {
                                $dfd.resolve(data);
                                $('#table-container').jtable('load');
                            },
                            error: function () {
                                $dfd.reject();
                            }
                        });
                    });
                },
                deleteAction: 'ajax/stores-ajax.php?action=delete'
            },
            fields:
            {
                store_id: {
                    key: true,
                    list: false,
                    title: 'id',
                },
                name: {
                    title: 'Store Name',
                },
                description:
                {
                    list: true,
                    title: 'Store Description',width: '50%',sorting: false,
                    input: function (data)
                    {
                        if (data.record)
                        {
                            return '<textarea cols="50" id="descriptionText" name="descriptionText" rows="4" wrap="hard">' + data.record.description+ '</textarea>';
                        }
                        else
                        {
                            return '<textarea cols="50" id="descriptionText" name="descriptionText" rows="4" wrap="hard" />';
                        }
                    },
                    display:function(data)
                    {
                        return data.record.description.substring(0,200);
                    }
                },
                image:
                {
                    list: true,
                    title: 'Store Logo',
                    type:'file',sorting: false,
                    display: function(data)
                    {
                        return '<img src="' + data.record.image +  '" width="150" height="150" class="preview">';
                    },
                    input: function (data)
                    {
                        //console.log(data.record.store_id);
                        if (data.record)
                        {
                            markup = (      '<div id="preview_' + data.record.store_id + '">'+
                                                '<img src="' + data.record.image +  '" width="150" height="150" class="preview" id="storeimg">'+
                                            '</div>' +
                                            '<br/><br/><input type="file" accept="image/*" name="imgupload" id="storeimg_upload" data-storeid="' + data.record.store_id + '"/ >');
                            return markup;
                        }
                        else
                        {
                            markup = (      '<div id="preview_0">'+
                                                '<img src="" width="150" height="150" class="preview" id="storeimg">'+
                                            '</div>' +
                                            '<br/><br/><input type="file" accept="image/*" id="storeimg_upload" data-storeid="0" name="imgupload"/ >');
                            return markup;
                        }
                    }


                },
                open:{list: true,title: 'Open', sorting: false},
                close:{list: true,title: 'Close',sorting: false},

           }
        });


        $('#storeTableContainer').jtable('load');





        $('#productTableContainer').jtable(
        {
            title: 'Product Table',


            formCreated: function (event, data)
            {
                data.form.attr('enctype','multipart/form-data');

            },
            formSubmitting: function(event, data)
            {
                //filename = $('input[type=file]').val().split('\\').pop();
                //alert(filename);
                //alert($("#" + data.form.attr("id")).find('input[name="image"]').val(filename));

            },
            paging: true, //Enable paging
            pageSize: 10, //Set page size (default: 10)
            sorting: true, //Enable sorting
            defaultSorting: 'Name ASC', //Set default sorting
            actions:
            {
                //listAction: 'ajax/category-ajax.php?action=list',
                listAction: function (postData, jtParams)
                {
                    console.log("Loading from custom function...");
                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/products-ajax.php?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            type: 'POST',
                            dataType: 'json',
                            data: postData,
                            success: function (data)
                            {
                                $dfd.resolve(data);
                            },
                            error: function ()
                            {
                                $dfd.reject();
                            }
                        });
                    });
                },

                //createAction: 'ajax/store-ajax.php?action=create',
                createAction: function (postData)
                {
                    var formData = getVars(postData);

                    if($('#productimg_upload').val() !== "")
                    {
                        formData.append("productimg", $('#productimg_upload').get(0).files[0]);
                    }

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/products-ajax.php?action=create',
                            //url: 'ajax/store-ajax.php?action=create&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            processData: false, // Don't process the files
                            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                            success: function (data)
                            {
                                $dfd.resolve(data);
                                $('#table-container').jtable('load');
                            },
                            error: function ()
                            {
                                $dfd.reject();
                            }
                        });
                    });
                },

                //updateAction: 'ajax/store-ajax.php?action=update',
                updateAction: function (postData)
                {
                    var formData = getVars(postData);

                    if($('#productimg_upload').val() !== "")
                    {
                        formData.append("productimg", $('#productimg_upload').get(0).files[0]);
                    }

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/products-ajax.php?action=update',
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            processData: false, // Don't process the files
                            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                            success: function (data)
                            {
                                $dfd.resolve(data);
                                $('#table-container').jtable('load');
                            },
                            error: function () {
                                $dfd.reject();
                            }
                        });
                    });
                },
                deleteAction: 'ajax/products-ajax.php?action=delete'
            },
            fields:
            {
                product_id: {
                    key: true,
                    list: false,
                    title: 'id',
                },
                name: {
                    title: 'Product Name',
                },
                description:
                {
                    list: true,
                    title: 'Product Description',width: '50%',sorting: false,
                    input: function (data)
                    {
                        if (data.record)
                        {
                            return '<textarea cols="50" id="productDescriptionText" name="productDescriptionText" rows="4" wrap="hard">' + data.record.description+ '</textarea>';
                        }
                        else
                        {
                            return '<textarea cols="50" id="productDescriptionText" name="productDescriptionText" rows="4" wrap="hard" />';
                        }
                    },
                    display:function(data)
                    {
                        return data.record.description.substring(0,200);
                    }
                },
                price:{list: true,title: 'Price (Rs)',},
                image:
                {
                    list: true,
                    title: 'Product Image',
                    type:'file',sorting: false,
                    display: function(data)
                    {
                        return '<img src="' + data.record.image +  '" width="150" height="150" class="preview">';
                    },
                    input: function (data)
                    {
                        //console.log(data.record.store_id);
                        if (data.record)
                        {
                            markup = (      '<div id="preview_' + data.record.store_id + '">'+
                            '<img src="' + data.record.image +  '" width="150" height="150" class="preview" id="productimg">'+
                            '</div>' +
                            '<br/><br/><input type="file" accept="image/*" name="product_imgupload" id="productimg_upload" data-productid="' + data.record.store_id + '"/ >');
                            return markup;
                        }
                        else
                        {
                            markup = (      '<div id="preview_0">'+
                            '<img src="" width="150" height="150" class="preview" id="productimg">'+
                            '</div>' +
                            '<br/><br/><input type="file" accept="image/*" id="productimg_upload" data-productid="0" name="product_imgupload"/ >');
                            return markup;
                        }
                    }


                },
                storeid:
                {
                    list: true,
                    title: 'Store Name',
                    options: storeArrayobj
                },
                categoryid:
                {
                    list: true,
                    title: 'Category',
                    options: categoryArrayobj
                },
            }
        });


        $('#LoadRecordsButton').click(function (e)
        {
            e.preventDefault();
            $('#productTableContainer').jtable('load',
                {
                    //name: $('#storename').val(),
                    storeid: $('#storeId').val()
                });
        });



        $('#productTableContainer').jtable('load');







        $('#smokersTableContainer').jtable(
        {
            title: 'Smokers Page Table',


            formCreated: function (event, data)
            {
                data.form.attr('enctype','multipart/form-data');

            },
            formSubmitting: function(event, data)
            {
                //filename = $('input[type=file]').val().split('\\').pop();
                //alert(filename);
                //alert($("#" + data.form.attr("id")).find('input[name="image"]').val(filename));

            },
            paging: true, //Enable paging
            pageSize: 10, //Set page size (default: 10)
            sorting: true, //Enable sorting
            defaultSorting: 'Name ASC', //Set default sorting
            actions:
            {
                //listAction: 'ajax/category-ajax.php?action=list',
                listAction: function (postData, jtParams)
                {
                    console.log("Loading from custom function...");
                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/smokers-ajax.php?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            type: 'POST',
                            dataType: 'json',
                            data: postData,
                            success: function (data)
                            {
                                $dfd.resolve(data);
                            },
                            error: function ()
                            {
                                $dfd.reject();
                            }
                        });
                    });
                },

                //createAction: 'ajax/store-ajax.php?action=create',
                createAction: function (postData)
                {
                    var formData = getVars(postData);

                    if($('#smokers_img_upload').val() !== "")
                    {
                        formData.append("smokersimg", $('#smokers_img_upload').get(0).files[0]);
                    }

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/smokers-ajax.php?action=create',
                            //url: 'ajax/store-ajax.php?action=create&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            processData: false, // Don't process the files
                            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                            success: function (data)
                            {
                                $dfd.resolve(data);
                                $('#table-container').jtable('load');
                            },
                            error: function ()
                            {
                                $dfd.reject();
                            }
                        });
                    });
                },

                //updateAction: 'ajax/store-ajax.php?action=update',
                updateAction: function (postData)
                {
                    var formData = getVars(postData);

                    if($('#smokers_img_upload').val() !== "")
                    {
                        formData.append("smokersimg", $('#smokers_img_upload').get(0).files[0]);
                    }

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/smokers-ajax.php?action=update',
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            processData: false, // Don't process the files
                            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                            success: function (data)
                            {
                                $dfd.resolve(data);
                                $('#table-container').jtable('load');
                            },
                            error: function () {
                                $dfd.reject();
                            }
                        });
                    });
                },
                deleteAction: 'ajax/smokers-ajax.php?action=delete'
            },
            fields:
            {
                id: {
                    key: true,
                    list: false,
                    title: 'id',
                },
                name: {
                    title: 'Item Name',
                },
                description:
                {
                    list: true,
                    title: 'Smokers Item Description',width: '50%',sorting: false,
                    input: function (data)
                    {
                        if (data.record)
                        {
                            return '<textarea cols="50" id="smokersDescriptionText" name="smokersDescriptionText" rows="4" wrap="hard">' + data.record.description+ '</textarea>';
                        }
                        else
                        {
                            return '<textarea cols="50" id="smokersDescriptionText" name="smokersDescriptionText" rows="4" wrap="hard" />';
                        }
                    },
                    display:function(data)
                    {
                        return data.record.description.substring(0,200);
                    }
                },
                image:
                {
                    list: true,
                    title: 'Smokers Item Image',
                    type:'file',sorting: false,
                    display: function(data)
                    {
                        return '<img src="' + data.record.image +  '" width="150" height="150" class="preview">';
                    },
                    input: function (data)
                    {
                        //console.log(data.record.store_id);
                        if (data.record)
                        {
                            markup = (      '<div id="preview_' + data.record.store_id + '">'+
                            '<img src="' + data.record.image +  '" width="150" height="150" class="preview" id="productimg">'+
                            '</div>' +
                            '<br/><br/><input type="file" accept="image/*" name="smokers_imgupload" id="smokers_img_upload" data-smokeid="' + data.record.store_id + '"/ >');
                            return markup;
                        }
                        else
                        {
                            markup = (      '<div id="preview_0">'+
                            '<img src="" width="150" height="150" class="preview" id="productimg">'+
                            '</div>' +
                            '<br/><br/><input type="file" accept="image/*" id="smokers_img_upload" data-smokeid="0" name="smokers_imgupload"/ >');
                            return markup;
                        }
                    }


                },
                price:{list: true,title: 'Price (Rs)',},
            }
        });

        $('#smokersTableContainer').jtable('load');


        //grocery
        $('#groceryTableContainer').jtable(
        {
            title: 'Grocery Page Table',


            formCreated: function (event, data)
            {
                data.form.attr('enctype','multipart/form-data');

            },
            formSubmitting: function(event, data)
            {
                //filename = $('input[type=file]').val().split('\\').pop();
                //alert(filename);
                //alert($("#" + data.form.attr("id")).find('input[name="image"]').val(filename));

            },
            paging: true, //Enable paging
            pageSize: 10, //Set page size (default: 10)
            sorting: true, //Enable sorting
            defaultSorting: 'Name ASC', //Set default sorting
            actions:
            {
                //listAction: 'ajax/category-ajax.php?action=list',
                listAction: function (postData, jtParams)
                {
                    console.log("Loading from custom function...");
                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/grocery-ajax.php?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            type: 'POST',
                            dataType: 'json',
                            data: postData,
                            success: function (data)
                            {
                                $dfd.resolve(data);
                            },
                            error: function ()
                            {
                                $dfd.reject();
                            }
                        });
                    });
                },

                //createAction: 'ajax/store-ajax.php?action=create',
                createAction: function (postData)
                {
                    var formData = getVars(postData);

                    if($('#grocery_img_upload').val() !== "")
                    {
                        formData.append("groceryimg", $('#grocery_img_upload').get(0).files[0]);
                    }

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/grocery-ajax.php?action=create',
                            //url: 'ajax/store-ajax.php?action=create&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            processData: false, // Don't process the files
                            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                            success: function (data)
                            {
                                $dfd.resolve(data);
                                $('#table-container').jtable('load');
                            },
                            error: function ()
                            {
                                $dfd.reject();
                            }
                        });
                    });
                },

                //updateAction: 'ajax/store-ajax.php?action=update',
                updateAction: function (postData)
                {
                    var formData = getVars(postData);

                    if($('#grocery_img_upload').val() !== "")
                    {
                        formData.append("groceryimg", $('#grocery_img_upload').get(0).files[0]);
                    }

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/grocery-ajax.php?action=update',
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            processData: false, // Don't process the files
                            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                            success: function (data)
                            {
                                $dfd.resolve(data);
                                $('#table-container').jtable('load');
                            },
                            error: function () {
                                $dfd.reject();
                            }
                        });
                    });
                },
                deleteAction: 'ajax/grocery-ajax.php?action=delete'
            },
            fields:
            {
                id: {
                    key: true,
                    list: false,
                    title: 'id',
                },
                name: {
                    title: 'Item Name',
                },
                description:
                {
                    list: true,
                    title: 'Description',width: '50%',sorting: false,
                    input: function (data)
                    {
                        if (data.record)
                        {
                            return '<textarea cols="50" id="groceryDescriptionText" name="groceryDescriptionText" rows="4" wrap="hard">' + data.record.description+ '</textarea>';
                        }
                        else
                        {
                            return '<textarea cols="50" id="groceryDescriptionText" name="groceryDescriptionText" rows="4" wrap="hard" />';
                        }
                    },
                    display:function(data)
                    {
                        return data.record.description.substring(0,200);
                    }
                },
                image:
                {
                    list: true,
                    title: 'Item Image',
                    type:'file',sorting: false,
                    display: function(data)
                    {
                        return '<img src="' + data.record.image +  '" width="150" height="150" class="preview">';
                    },
                    input: function (data)
                    {
                        //console.log(data.record.store_id);
                        if (data.record)
                        {
                            markup = (      '<div id="preview_' + data.record.store_id + '">'+
                            '<img src="' + data.record.image +  '" width="150" height="150" class="preview" id="groceryimg">'+
                            '</div>' +
                            '<br/><br/><input type="file" accept="image/*" name="grocery_imgupload" id="grocery_img_upload" data-groceryid="' + data.record.store_id + '"/ >');
                            return markup;
                        }
                        else
                        {
                            markup = (      '<div id="preview_0">'+
                            '<img src="" width="150" height="150" class="preview" id="groceryimg">'+
                            '</div>' +
                            '<br/><br/><input type="file" accept="image/*" id="grocery_img_upload" data-groceryid="0" name="grocery_imgupload"/ >');
                            return markup;
                        }
                    }


                },
                price:{list: true,title: 'Price (Rs)',},
            }
        });

        $('#groceryTableContainer').jtable('load');



        //fun accessories
        $('#funAccessoriesTableContainer').jtable(
        {
            title: 'Fun Accessories Page Table',


            formCreated: function (event, data)
            {
                data.form.attr('enctype','multipart/form-data');

            },
            formSubmitting: function(event, data)
            {
                //filename = $('input[type=file]').val().split('\\').pop();
                //alert(filename);
                //alert($("#" + data.form.attr("id")).find('input[name="image"]').val(filename));

            },
            paging: true, //Enable paging
            pageSize: 10, //Set page size (default: 10)
            sorting: true, //Enable sorting
            defaultSorting: 'Name ASC', //Set default sorting
            actions:
            {
                //listAction: 'ajax/category-ajax.php?action=list',
                listAction: function (postData, jtParams)
                {
                    console.log("Loading from custom function...");
                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/fun-accessories-ajax.php?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            type: 'POST',
                            dataType: 'json',
                            data: postData,
                            success: function (data)
                            {
                                $dfd.resolve(data);
                            },
                            error: function ()
                            {
                                $dfd.reject();
                            }
                        });
                    });
                },

                //createAction: 'ajax/store-ajax.php?action=create',
                createAction: function (postData)
                {
                    var formData = getVars(postData);

                    if($('#funAccessories_img_upload').val() !== "")
                    {
                        formData.append("FAimg", $('#funAccessories_img_upload').get(0).files[0]);
                    }

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/fun-accessories-ajax.php?action=create',
                            //url: 'ajax/store-ajax.php?action=create&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            processData: false, // Don't process the files
                            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                            success: function (data)
                            {
                                $dfd.resolve(data);
                                $('#table-container').jtable('load');
                            },
                            error: function ()
                            {
                                $dfd.reject();
                            }
                        });
                    });
                },

                //updateAction: 'ajax/store-ajax.php?action=update',
                updateAction: function (postData)
                {
                    var formData = getVars(postData);

                    if($('#funAccessories_img_upload').val() !== "")
                    {
                        formData.append("FAimg", $('#funAccessories_img_upload').get(0).files[0]);
                    }

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/fun-accessories-ajax.php?action=update',
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            processData: false, // Don't process the files
                            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                            success: function (data)
                            {
                                $dfd.resolve(data);
                                $('#table-container').jtable('load');
                            },
                            error: function () {
                                $dfd.reject();
                            }
                        });
                    });
                },
                deleteAction: 'ajax/fun-accessories-ajax.php?action=delete'
            },
            fields:
            {
                id: {
                    key: true,
                    list: false,
                    title: 'id',
                },
                name: {
                    title: 'Item Name',
                },
                description:
                {
                    list: true,
                    title: 'Description',width: '50%',sorting: false,
                    input: function (data)
                    {
                        if (data.record)
                        {
                            return '<textarea cols="50" id="funAccessoriesDescriptionText" name="funAccessoriesDescriptionText" rows="4" wrap="hard">' + data.record.description+ '</textarea>';
                        }
                        else
                        {
                            return '<textarea cols="50" id="funAccessoriesDescriptionText" name="funAccessoriesDescriptionText" rows="4" wrap="hard" />';
                        }
                    },
                    display:function(data)
                    {
                        console.log(data);
                        return data.record.description.substring(0,200);
                    }
                },
                image:
                {
                    list: true,
                    title: 'Item Image',
                    type:'file',sorting: false,
                    display: function(data)
                    {
                        return '<img src="' + data.record.image +  '" width="150" height="150" class="preview">';
                    },
                    input: function (data)
                    {
                        //console.log(data.record.store_id);
                        if (data.record)
                        {
                            markup = (      '<div id="preview_' + data.record.store_id + '">'+
                            '<img src="' + data.record.image +  '" width="150" height="150" class="preview" id="productimg">'+
                            '</div>' +
                            '<br/><br/><input type="file" accept="image/*" name="funAccessories_imgupload" id="funAccessories_img_upload" data-funAccessoriesid="' + data.record.store_id + '"/ >');
                            return markup;
                        }
                        else
                        {
                            markup = (      '<div id="preview_0">'+
                            '<img src="" width="150" height="150" class="preview" id="productimg">'+
                            '</div>' +
                            '<br/><br/><input type="file" accept="image/*" id="funAccessories_img_upload" data-funAccessoriesid="0" name="funAccessories_imgupload"/ >');
                            return markup;
                        }
                    }


                },
                price:{
                    list: true,
                    title: 'Price (Rs)',
                },
            }
        });

        $('#funAccessoriesTableContainer').jtable('load');

        $('#eventTableContainer').jtable(
        {
            title: 'Event Page Table',


            formCreated: function (event, data)
            {
                data.form.attr('enctype','multipart/form-data');

            },
            formSubmitting: function(event, data)
            {
                //filename = $('input[type=file]').val().split('\\').pop();
                //alert(filename);
                //alert($("#" + data.form.attr("id")).find('input[name="image"]').val(filename));

            },
            paging: true, //Enable paging
            pageSize: 10, //Set page size (default: 10)
            sorting: true, //Enable sorting
            defaultSorting: 'Name ASC', //Set default sorting
            actions:
            {
                //listAction: 'ajax/category-ajax.php?action=list',
                listAction: function (postData, jtParams)
                {
                    console.log("Loading from custom function...");
                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/event-ajax.php?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            type: 'POST',
                            dataType: 'json',
                            data: postData,
                            success: function (data)
                            {
                                $dfd.resolve(data);
                            },
                            error: function ()
                            {
                                $dfd.reject();
                            }
                        });
                    });
                },

                //createAction: 'ajax/store-ajax.php?action=create',
                createAction: function (postData)
                {
                    var formData = getVars(postData);

                    if($('#event_img_upload').val() !== "")
                    {
                        formData.append("eventimg", $('#event_img_upload').get(0).files[0]);
                    }

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/event-ajax.php?action=create',
                            //url: 'ajax/store-ajax.php?action=create&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            processData: false, // Don't process the files
                            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                            success: function (data)
                            {
                                $dfd.resolve(data);
                                $('#table-container').jtable('load');
                            },
                            error: function ()
                            {
                                $dfd.reject();
                            }
                        });
                    });
                },

                //updateAction: 'ajax/store-ajax.php?action=update',
                updateAction: function (postData)
                {
                    var formData = getVars(postData);

                    if($('#event_img_upload').val() !== "")
                    {
                        formData.append("eventimg", $('#event_img_upload').get(0).files[0]);
                    }

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'ajax/event-ajax.php?action=update',
                            type: 'POST',
                            dataType: 'json',
                            data: formData,
                            processData: false, // Don't process the files
                            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                            success: function (data)
                            {
                                $dfd.resolve(data);
                                $('#table-container').jtable('load');
                            },
                            error: function () {
                                $dfd.reject();
                            }
                        });
                    });
                },
                deleteAction: 'ajax/event-ajax.php?action=delete'
            },
            fields:
            {
                id: {
                    key: true,
                    list: false,
                    title: 'id',
                },
                name: {
                    title: 'Event Name',
                },
                description:
                {
                    list: true,
                    title: 'Description',width: '50%',sorting: false,
                    input: function (data)
                    {
                        if (data.record)
                        {
                            return '<textarea cols="50" id="eventDescriptionText" name="eventDescriptionText" rows="4" wrap="hard">' + data.record.description+ '</textarea>';
                        }
                        else
                        {
                            return '<textarea cols="50" id="eventDescriptionText" name="eventDescriptionText" rows="4" wrap="hard" />';
                        }
                    },
                    display:function(data)
                    {
                        return data.record.description.substring(0,200);
                    }
                },
                image:
                {
                    list: true,
                    title: 'Event Image',
                    type:'file',sorting: false,
                    display: function(data)
                    {
                        return '<img src="' + data.record.image +  '" width="150" height="150" class="preview">';
                    },
                    input: function (data)
                    {
                        //console.log(data.record.store_id);
                        if (data.record)
                        {
                            markup = (      '<div id="preview_' + data.record.store_id + '">'+
                            '<img src="' + data.record.image +  '" width="150" height="150" class="preview" id="eventimg">'+
                            '</div>' +
                            '<br/><br/><input type="file" accept="image/*" name="event_imgupload" id="event_img_upload" data-eventid="' + data.record.store_id + '"/ >');
                            return markup;
                        }
                        else
                        {
                            markup = (      '<div id="preview_0">'+
                            '<img src="" width="150" height="150" class="preview" id="eventimg">'+
                            '</div>' +
                            '<br/><br/><input type="file" accept="image/*" id="event_img_upload" data-eventid="0" name="event_imgupload"/ >');
                            return markup;
                        }
                    }


                },

            }
        });

        $('#eventTableContainer').jtable('load');



        $('button.ui-dialog-titlebar-close').html('X');

    });






    $(document).on('change','#event_img_upload', function()
    {
        console.log(this);
        console.log($(this));
        var id=this.id;
        var eventid = $(this).data('eventid');


        //alert(storeid);
        readURL(this,eventid);


    });


    $(document).on('change','#smokers_img_upload', function()
    {
        console.log(this);
        console.log($(this));
        var id=this.id;
        var smokeid = $(this).data('smokeid');


        //alert(storeid);
        readURL(this,smokeid);


    });

    $(document).on('change','#funAccessories_img_upload', function()
    {
        console.log(this);
        console.log($(this));
        var id=this.id;
        var faid = $(this).data('funaccessoriesid');


        //alert(storeid);
        readURL(this,faid);


    });
    $(document).on('change','#grocery_img_upload', function()
    {
        console.log(this);
        console.log($(this));
        var id=this.id;
        var groceryid = $(this).data('groceryid');


        //alert(storeid);
        readURL(this,groceryid);


    });
    $(document).on('change','#productimg_upload', function()
    {
        console.log(this);
        console.log($(this));
        var id=this.id;
        var productid = $(this).data('productid');


        //alert(productid);
        readURL(this,productid);


    });

    */
</script>





</body>
</html>
