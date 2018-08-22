<?php
if ($fotoEdit == null)
    $fotoEdit = ''
?>
<div class="image bg-food pos-rel all-height">
    <button id="btnResetImage" class="mdl-button indigo z-depth-2 padding10 mdl-js-button mdl-js-ripple-effect mdl-button--icon place-top-right oculto clean-button white-text margin10" type="button">
        <i class="material-icons md-32">&#xE5C9;</i>
    </button>
    <img id="imgFoto" src="" alt="" class="hide">
    <div class="modal-example-overlay hide">
        <div class="bg-preloader-wrapper centered circle white">
            <div class="centered mdl-spinner mdl-js-spinner is-active"></div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<input type="file" id="fileUploadImage" name="fileUploadImage">