/**
 * 全局消息提示框方法
 * @param  string message 需要显示的提示信息
 */
function notify( message )
{
    if( !$ ) {
        alert( message );
        return;
    }
    /**
    <div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="mySmallModalLabel">Small modal</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
            </div>
        </div>
    </div>
     */
    var messageBox = '<div class="modal bs-example-modal-sm" style="float:right" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="notify-dialog"><div class="modal-sm"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button><h4 class="modal-title" id="mySmallModalLabel">Notify</h4></div><div class="modal-body" id="notify-content"></div></div></div></div>';
    $("body").append( messageBox );
    $(".modal-body").html( message );
    $("#notify-dialog").fadeIn( 400 ).delay( 1000 ).fadeOut( 400, function() {
        $( this ).remove();
    });
};