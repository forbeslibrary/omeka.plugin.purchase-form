<?php
/**
 * Outputs a configuration form for the ForbesPurchaseForm plugin.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @todo This code is an artifact of another plugin and needs to be
 * rewritten.
 */

echo js('tiny_mce/tiny_mce'); ?>
<script type="text/javascript">
jQuery(window).load(function () {
    Omeka.wysiwyg({
        mode: 'specific_textareas',
        editor_selector: 'html-editor'
    });
});
</script>

<?php
$reply_from_email = get_option('forbes_purchase_form_reply_from_email');
$forward_to_email = get_option('forbes_purchase_form_forward_to_email');
$view = __v();
?>

<?php if (!Omeka_Captcha::isConfigured()): ?>
    <p class="alert">You have not entered your <a href="http://recaptcha.net/">reCAPTCHA</a>
        API keys under <a href="<?php echo uri('security#recaptcha_public_key'); ?>">security settings</a>. We recommend adding these keys, or the contact form will be vulnerable to spam.</p>
<?php endif; ?>

<div class="field">
    <?php echo $view->formLabel('reply_from_email', 'Reply-From Email'); ?>
    <div class="inputs">
        <?php echo $view->formText('reply_from_email', $reply_from_email, array('class' => 'textinput')); ?>
        <p class="explanation">
            The address that users can reply to. If blank, your users will not
            be sent confirmation emails of their submissions.
        </p>
    </div>
</div>

<div class="field">
    <?php echo $view->formLabel('forward_to_email', 'Forward-To Email'); ?>
    <div class="inputs">
        <?php echo $view->formText('forward_to_email', $forward_to_email, array('class' => 'textinput')); ?>
        <p class="explanation">
            The email address that receives notifications that someone has
            submitted a message through the contact form. If blank, you will not
            be forwarded messages from your users.
        </p>
    </div>
</div>
