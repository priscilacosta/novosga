<?php
use \core\SGA;

$guiche = $context->getSession()->get('guiche');
?>
<div id="dialog-guiche" title="<?php echo _('Guichê') ?>" style="display:none">
    <form id="guiche_form" action="<?php echo SGA::url('set_guiche') ?>" method="post">
        <div>
            <label><?php echo _('Número') ?></label>
            <input type="text" id="numero_guiche" name="guiche" maxlength="3" class="w50" value="<?php echo $context->getCookie()->get('guiche') ?>" />
        </div>
    </form>
    <script type="text/javascript">
        $('#guiche_form').on('submit', function() {
            var numero = parseInt($('#numero_guiche').val().trim());
            if (isNaN(numero) || numero <= 0) {
                $('#numero_guiche').val('');
                return false;
            }
            return true;
        });
    </script>
</div>
<?php

// se ainda nao definiu o guiche, exibe automaticamente a dialog
if ($guiche <= 0) {
    ?>
    <script type="text/javascript">SGA.Atendimento.updateGuiche("<?php echo _('Salvar') ?>"); $('#guiche').focus();</script>
    <?php
} 
// guiche definido, exibe tela de atendimento
else {
    ?>
    <div id="atendimento">
        <div id="guiche">
            <span class="label"><?php echo _('Guichê') ?></span>
            <span class="numero"><?php echo $guiche ?></span>
            <a href="javascript:void(0)" onclick="SGA.Atendimento.updateGuiche('<?php echo _('Salvar') ?>')"><?php echo _('Alterar') ?></a>
        </div>
        <div id="controls">
            <div id="chamar" class="control">
                <a href="javascript:void(0)" onclick="SGA.Atendimento.chamar()">chamar proximo</a>
            </div>
            <div id="iniciar" class="control" style="display:none">
                <a href="javascript:void(0)" onclick="SGA.Atendimento.iniciar()">iniciar atendimento</a>
            </div>
            <div id="encerrar" class="control" style="display:none">
                <a href="javascript:void(0)" onclick="SGA.Atendimento.encerrar()">encerrar atendimento</a>
            </div>
        </div>
        <div id="fila">
            <span><?php echo _('Minha fila') ?>:</span>
            <ul></ul>
        </div>
    </div>
    <script type="text/javascript">
        SGA.Atendimento.init();
    </script>
    <?php
}
?>
