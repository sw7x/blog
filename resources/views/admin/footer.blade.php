

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
						postData = {
							"_token": "{{ csrf_token() }}",
                        };

                        return $.Deferred(function ($dfd)
                        {
                            $.ajax({
                                url: 'contact/view?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
								//url: 'contact/view',
								type: 'POST',
                                dataType: 'json',
                                data: postData,
                                success: function (data){
                                    $dfd.resolve(data);
                                },
                                error: function (){
                                    $dfd.reject();
                                }
                            });
                        });
                    },
                    // createAction: 'ajax/view-comment-ajax.php?action=create',
                    // updateAction: 'ajax/view-comment-ajax.php?action=update',
                    //deleteAction: 'contact/delete'
					deleteAction: function (postData, jtParams)
					{
						console.log("Loading from custom function...");
						postData = {...postData,...{"_token": "{{ csrf_token() }}"}};

						return $.Deferred(function ($dfd)
						{
							$.ajax({
								//url: 'contact/view?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
								url: 'contact/delete',
								type: 'POST',
								dataType: 'json',
								data: postData,
								success: function (data){
									$dfd.resolve(data);
								},
								error: function (){
									$dfd.reject();
								}
							});
						});
					},
                },
                fields: {
                    id: {
                        key: true,
                        list: false,
                        title: 'id',
                    },
                    name: {
                        title: 'Name',
                        width: '20%'
                    },
                    email: {
                        title: 'E-Mail',
                        width: '20%'
                    },
					mobile: {
						title: 'Mobile',
						width: '10%'
					},
					subject: {
						title: 'Subject',
						width: '10%'
					},
                    message: {
                        title: 'Message',
                        width: '30%',
                        sorting: false,
                    },
					created_at: {
						title: 'Submit at',
						width: '10%'
					},
                }
        });

        $('#viewCommentTableContainer').jtable('load');



        $('#packagesTableContainer').jtable(
        {
            title: 'packages Table',
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
					postData = {...postData,...{"_token": "{{ csrf_token() }}"}};
                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            //url: 'ajax/stores-ajax.php?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
							url: 'packages/view?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
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

                    if($('#packageImg_upload').val() !== ""){
                        formData.append("packageImg", $('#packageImg_upload').get(0).files[0]);
                    }
					formData.append("_token", '{{ csrf_token() }}');

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'packages/create?action=create',
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

                    if($('#packageImg_upload').val() !== ""){
                        formData.append("packageImg_update", $('#packageImg_upload').get(0).files[0]);
                    }
					formData.append("_token", '{{ csrf_token() }}');
                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'packages/update?action=update',
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
                deleteAction: function (postData, jtParams)
				{
					console.log("Loading from custom function...");
					postData = {...postData,...{"_token": "{{ csrf_token() }}"}}

					return $.Deferred(function ($dfd)
					{
						$.ajax({
							//url: 'contact/view?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
							url: 'packages/delete?action=delete',
							type: 'POST',
							dataType: 'json',
							data: postData,
							success: function (data){
								$dfd.resolve(data);
							},
							error: function (){
								$dfd.reject();
							}
						});
					});
				},
            },
            fields:
            {
                id: {
                    key: true,
                    list: false,
                    title: 'id',
                },
                title: {
                    title: '<label for="title">Title</label>',
                    list: true,
                    width: '20%',
					input:function (data){

						if (data.record){
							var inputData = data.record.title;
						}else{
							var inputData = '';
						}
						return  '<div class="form-group">' +
                                    '<input class="form-control" type="text" id="title" name="title" value="' + inputData +'"/>' +
                                '</div>';
					},
                },
				price: {
					title: '<label for="price">Price</label>',
                    width: '10%',
                    list: true,
					input:function (data){

						if (data.record){
							var inputData = data.record.price;
						}else{
							var inputData = '';
						}
						return  '<div class="form-group">' +
							        '<input class="form-control" type="text" id="price" name="price" value="' + inputData +'"/>' +
							    '</div>';
					},
				},
                description:
                {
                    list: true,
                    title: '<label for="descriptionText">Description</label>',
                    width: '30%',
                    sorting: false,
                    input: function (data)
                    {
						let inputData;
						if (data.record)
                        {
							inputData = data.record.description;
                        }
                        else
                        {
							inputData = '';
                        }

					    return  '<div class="form-group">' +
                                    '<textarea cols="50" class="form-control" rows="5" id="descriptionText" name="descriptionText" rows="4" wrap="hard">' +  inputData + '</textarea>' +
                                '</div>';
                    },
                    display:function(data)
                    {
                        return data.record.description.substring(0,200);
                    }
                },
                image:
                {
                    list: true,
                    title: '<label for="">Package image</label>',
                    type:'file',
                    width: '25%',
                    sorting: false,
                    display: function(data)
                    {
                        return '<img src="/storage/package_images/' + data.record.image +  '" width="150" height="150" class="preview">';
                    },
                    input: function (data)
                    {
                        //console.log(data.record.store_id);
						let prevClass;
						let imgPath;
						let packageId;
                        if (data.record)
                        {
                            prevClass = data.record.id;
							imgPath = '/storage/package_images/' + data.record.image;
                            packageId = data.record.id;//
                        }
                        else
                        {
                        	prevClass = "0";
                        	imgPath = "";
							packageId = 0;//
                        }

						markup = (  '<div id="preview_' + prevClass + '">'+
							        '<img src="' + imgPath +  '" width="150" height="150" class="preview" id="packageImg">'+
                                    '</div>' +
                                    '<br/>' +
                                    //'<input class="zzzz" type="file" accept="image/*" name="imgupload" id="packageImg_upload" data-storeid="' + data.record.store_id + '"/ >' +
                                    '<div class="sazzad-file-upload">' +
                                        '<div class="file-select">' +
                                            '<div class="file-select-button" id="fileName">Choose File</div>' +
                                            '<div class="file-select-name" id="noFile">No file chosen...</div>' +
                                            '<input type="file" name="imgupload" id="packageImg_upload" accept="image/*" data-storeid="' + packageId + '" />' +
                                        '</div>' +
                                    '</div>'
						);
						return markup;
                    }
                },
                duration:{
                	list: true,
                    title: '<label for="duration">Duration</label>',
                    sorting: false,
                    width: '15%',
					input: function (data)
					{
						let inputData;
						if (data.record)
						{
							inputData = data.record.duration;
						}
						else
						{
							inputData = '';
						}

						return  '<div class="form-group">' +
                                    '<input class="form-control" type="text" id="duration" name="duration" value="' + inputData +'"/>' +
							    '</div>';
					},

                },
				highlights1:{
                	list: false,
                    title: false,
                    sorting: false,
                    input:function (data){

						if (data.record){
							var inputData = data.record.highlights1;
							inputData = (inputData)?inputData:'';
                        }else{
							var inputData = '';
                        }
						return  '<div class="form-group">' +
                                '<label for="highlights1Text">highlights1</label>' +
                                    '<input class="form-control" type="text" id="highlights1Text" name="highlights1Text" value="' + inputData +'"/>' +
                                '</div>';
                    },
                },
				highlights2:{
					list: false,
					title: false,
					sorting: false,
					input:function (data){

						if (data.record){
							var inputData = data.record.highlights2;
							inputData = (inputData)?inputData:'';
						}else{
							var inputData = '';
						}
						return  '<div class="form-group">' +
							'<label for="highlights2Text">highlights2</label>' +
							'<input class="form-control" type="text" id="highlights2Text" name="highlights2Text" value="' + inputData +'"/>' +
							'</div>';
					},
				},
				highlights3:{
					list: false,
					title: false,
					sorting: false,
					input:function (data){

						if (data.record){
							var inputData = data.record.highlights3;
							inputData = (inputData)?inputData:'';
						}else{
							var inputData = '';
						}
						return  '<div class="form-group">' +
							'<label for="highlights3Text">highlights3</label>' +
							'<input class="form-control" type="text" id="highlights3Text" name="highlights3Text" value="' + inputData +'"/>' +
							'</div>';
					},
				},
				highlights4:{
					list: false,
					title: false,
					sorting: false,
					input:function (data){

						if (data.record){
							var inputData = data.record.highlights4;
							inputData = (inputData)?inputData:'';
						}else{
							var inputData = '';
						}
						return  '<div class="form-group">' +
							'<label for="highlights4Text">highlights4</label>' +
							'<input class="form-control" type="text" id="highlights4Text" name="highlights4Text" value="' + inputData +'"/>' +
							'</div>';
					},
				},
				highlights5:{
					list: false,
					title: false,
					sorting: false,
					input:function (data){

						if (data.record){
							var inputData = data.record.highlights5;
							    inputData = (inputData)?inputData:'';
						}else{
							var inputData = '';
						}
						return  '<div class="form-group">' +
							'<label for="highlights5Text">highlights5</label>' +
							'<input class="form-control" type="text" id="highlights5Text" name="highlights5Text" value="' + inputData +'"/>' +
							'</div>';
					},
				},
           }
        });

        $('#packagesTableContainer').jtable('load');





        ///////////////////////


        $('#homeSliderTableContainer').jtable(
        {
            title: 'home slider Table',
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
                    postData = {...postData,...{"_token": "{{ csrf_token() }}"}};
                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            //url: 'ajax/stores-ajax.php?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            url: 'home-slider/view?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
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

                    if($('#homeslider_upload').val() !== ""){
                        formData.append("homesliderImg", $('#homeslider_upload').get(0).files[0]);
                    }
                    formData.append("_token", '{{ csrf_token() }}');

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'home-slider/create?action=create',
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

                    if($('#homeslider_upload').val() !== ""){
                        formData.append("homesliderImg_update", $('#homeslider_upload').get(0).files[0]);
                    }
                    formData.append("_token", '{{ csrf_token() }}');
                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            url: 'home-slider/update?action=update',
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
                deleteAction: function (postData, jtParams)
                {
                    console.log("Loading from custom function...");
                    postData = {...postData,...{"_token": "{{ csrf_token() }}"}}

                    return $.Deferred(function ($dfd)
                    {
                        $.ajax({
                            //url: 'contact/view?action=list&jtStartIndex=' + jtParams.jtStartIndex + '&jtPageSize=' + jtParams.jtPageSize + '&jtSorting=' + jtParams.jtSorting,
                            url: 'home-slider/delete?action=delete',
                            type: 'POST',
                            dataType: 'json',
                            data: postData,
                            success: function (data){
                                $dfd.resolve(data);
                            },
                            error: function (){
                                $dfd.reject();
                            }
                        });
                    });
                },
            },
            fields:
            {
                id: {
                    key: true,
                    list: false,
                    title: 'id',
                },                
                image:
                {
                    list: true,
                    title: '<label for="">Home Slider image</label><br>',
                    type:'file',
                    width: '25%',
                    sorting: false,
                    display: function(data)
                    {
                        return '<img src="/storage/' + data.record.image +  '" width="150" height="150" class="preview">';
                    },
                    input: function (data)
                    {
                        //console.log(data.record.store_id);
                        let prevClass;
                        let imgPath;
                        let sliderImgId;
                        if (data.record)
                        {
                            prevClass = data.record.id;
                            imgPath = '/storage/' + data.record.image;
                            sliderImgId = data.record.id;//
                        }
                        else
                        {
                            prevClass = "0";
                            imgPath = "";
                            sliderImgId = 0;//
                        }

                        markup = (  '<div id="preview_' + prevClass + '">'+
                                        '<img src="' + imgPath +  '" width="150" height="150" class="preview" id="sliderimg">'+
                                    '</div>' +
                                    '<br/>' +
                                    //'<input class="zzzz" type="file" accept="image/*" name="imgupload" id="packageImg_upload" data-storeid="' + data.record.store_id + '"/ >' +
                                    '<div class="sazzad-file-upload">' +
                                        '<div class="file-select">' +
                                            '<div class="file-select-button" id="fileName">Choose File</div>' +
                                            '<div class="file-select-name" id="noFile">No file chosen...</div>' +
                                            '<input type="file" name="imgupload" id="homeslider_upload" accept="image/*" data-imgid="' + sliderImgId + '" />' +
                                        '</div>' +
                                    '</div>'
                        );
                        return markup;
                    }
                },
                enable:{
                    list: true,
                    title: '<label for="status">Enable/Disable</label>',
                    sorting: false,
                    width: '15%',
                    display: function(data)
                    {
                        var stat;
                        if (data.record.enable)
                        {
                            stat = "Enable";
                        }
                        else
                        {
                            stat = 'Disable';
                        }

                        return stat;

                    },
                    input: function (data)
                    {
                        let inputData;
                        if (data.record)
                        {
                            inputData = data.record.enable;
                        }
                        else
                        {
                            inputData = '1';
                        }

                        isEnable =  (inputData)?'checked':'';
                        isDisable = (inputData)?'':'checked';

                        return  '<div class="form-group">' +
                                    '<fieldset id="image-status">' +
                                        '<label class="radio-inline"><input type="radio" value="enable" name="image_status" id="image-status-enable" '+ isEnable +'>Enable</label>' +
                                        '<label class="radio-inline"><input type="radio" value="disable" name="image_status" id="image-status-disable" '+ isDisable +'>Disable</label>' +
                                    '</fieldset>' +
                                '</div>';                        

                    },

                },                
           }
        });

        $('#homeSliderTableContainer').jtable('load');













        $(document).on('change','#packageImg_upload', function(){
            console.log(this);
            console.log($(this));
            var id=this.id;
            var storeid = $(this).data('storeid');

            //alert(storeid);
            readURL(this,storeid);
        });

        $(document).on('change','#homeslider_upload', function(){
            console.log(this);
            console.log($(this));
            var id=this.id;
            var imgid = $(this).data('imgid');

            //alert(storeid);
            readURL(this,imgid);
        });

        function readURL(input,storeid){
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
        function getVars(url){
            var formData = new FormData();
            var split;
            $.each(url.split("&"), function(key, value)
            {
                split = value.split("=");
                formData.append(split[0], decodeURIComponent(split[1].replace(/\+/g, " ")));
            });
            return formData;
        }



        function UrlParamsToObj(url){
            //var search = location.search.substring(1);
            var search = url;
            return JSON.parse('{"' + search.replace(/&/g, '","').replace(/=/g,'":"') + '"}', function(key, value)
            {
                return key===""?value:decodeURIComponent(value)
            });
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
