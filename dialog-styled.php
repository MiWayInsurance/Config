<?php include 'includes/head2.php'; ?>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.dialogextend.1_0_1.js"></script>
<body>
<?php include 'includes/header.php'; ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="container-fluid">
            <button type="button" id="my-button" class="btn btn-large btn-primary">Open more windows</button>
            <hr />
            <div class="btn-toolbar">
                <div class="btn-group">
                    <button id="opener1" class="btn">Open window 1</button>
                    <button id="opener2" class="btn">Open window 2</button>
                    <button id="opener3" class="btn">Open window 3</button>
                </div>
            </div>
            <div id="opener-content1" style="display: none;">
                <p>v quam eu pellentesque. Nam euismod, lectus sit amet tristique imperdiet, metus ligula gravida felis, non dapibus nulla sem a magna.</p>
            </div>
            <div id="opener-content2" style="display: none;">
                <p>Fusce hendrerit lacinia ligula.</p>
                <p>Donec a tincidunt nisi.</p>
                <p> Cras eu velit sed nibh feugiat congue lacinia ut urna. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
            </div>
            <div id="opener-content3" style="display: none;">
                <p>v quam eu pellentesque. Nam euismod, lectus sit amet tristique imperdiet, metus ligula gravida felis, non dapibus nulla sem a magna.</p>
                <p>habitasse platea dictumst. Donec elementum vulputate imperdiet. Fusce sed lectus odio. Etiam cursus fermentum ornare. Phasellus facilisis t</p>
                <p> Quisque nec lobortis leo.</p>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        var positionNextWindowY = 0;
        var positionNextWindowX=0;
        var positionNextWindowCounter = -35;
        function newPositionWindow(){
            var TTEmp = positionNextWindowY/15;
            if( TTEmp > 10){
                positionNextWindowX = positionNextWindowCounter;
                positionNextWindowY = 0;
                positionNextWindowCounter = positionNextWindowCounter -35;
                var needPosition = 'center+' + positionNextWindowX + ' center+' + positionNextWindowY;
                return needPosition;
            }else{
                positionNextWindowY = positionNextWindowY +15;
                positionNextWindowX =  positionNextWindowX +15;
                var needPosition = 'center+' +  positionNextWindowX + ' center+' + positionNextWindowY;
                return needPosition;
            }
        }
        var isOpen;
        $("#my-button").click(function(){
                var offsetwindow = newPositionWindow();
                var dialogOptions = {
                    title : "dialog window",
                    width : 400,
                    height : 300,
                    position: {
                        my: offsetwindow,
                        at: "center center",
                        of: $('body')
                    },
                    "close" : function(){ $(this).dialog( "destroy" ) }
                };
                var dialogExtendOptions = {
                    "maximize" : true,
                    "minimize" : true,
                    "dblclick": "maximize"
                };

                //$(".test-dialog-content").dialog(dialogOptions).dialogExtend(dialogExtendOptions);
                $("<div>Some text if you need will be here</div>").dialog(dialogOptions).dialogExtend(dialogExtendOptions);
        });
        $("#opener1").click(function(){
            try{
                isOpen = $('#opener-content1').dialog("isOpen");
            } catch(e) {
                isOpen = false;
            }
            if (isOpen === false ){
                var offsetwindow = newPositionWindow();
                var dialogOptions = {
                    title : "dialog window",
                    width : 400,
                    height : 300,
                    position: {
                        my: offsetwindow,
                        at: "center center",
                        of: $('body')
                    },
                    "close" : function(){ $(this).dialog( "destroy" ) }
                };
                var dialogExtendOptions = {
                    "maximize" : true,
                    "minimize" : true,
                    "dblclick": "maximize"
                };

                $("#opener-content1").dialog(dialogOptions).dialogExtend(dialogExtendOptions);
            }
        });
        $("#opener2").click(function(){
            try{
                isOpen = $('#opener-content2').dialog("isOpen");
            } catch(e) {
                isOpen = false;
            }
            if (isOpen === false ){
                var offsetwindow = newPositionWindow();
                var dialogOptions = {
                    title : "dialog window",
                    width : 400,
                    height : 300,
                    position: {
                        my: offsetwindow,
                        at: "center center",
                        of: $('body')
                    },
                    "close" : function(){ $(this).dialog( "destroy" ) }
                };
                var dialogExtendOptions = {
                    "maximize" : true,
                    "minimize" : true,
                    "dblclick": "maximize"
                };

                $("#opener-content2").dialog(dialogOptions).dialogExtend(dialogExtendOptions);
            }
        });
        $("#opener3").click(function(){
            try{
                isOpen = $('#opener-content3').dialog("isOpen");
            } catch(e) {
                isOpen = false;
            }
            if (isOpen === false ){
                var offsetwindow = newPositionWindow();
                var dialogOptions = {
                    title : "dialog window",
                    width : 400,
                    height : 300,
                    position: {
                        my: offsetwindow,
                        at: "center center",
                        of: $('body')
                    },
                    "close" : function(){ $(this).dialog( "destroy" ) }
                };
                var dialogExtendOptions = {
                    "maximize" : true,
                    "minimize" : true,
                    "dblclick": "maximize"
                };
                $("#opener-content3").dialog(dialogOptions).dialogExtend(dialogExtendOptions);
            }
        });
    });
</script>
<?php /* include 'includes/footer.php'; */ ?>
</body>
</html>