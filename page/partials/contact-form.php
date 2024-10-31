<?php
$ncf = nocake_forms();
?>
<div class="ncforms-contact js-ncforms-contact-us-modal" style="display: none">
    <div class="ncforms-contact--header">
        <span class="ncforms-contact--heading">
            Send us your feedback
            <small>Found a bug or you have got a feature request?</small>
        </span>
        <a class="ncforms-contact--close js-ncforms-contact-us-close">
            <svg style="width: 20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="#e6e6e6" d="M10 1.6a8.4 8.4 0 1 0 0 16.8 8.4 8.4 0 0 0 0-16.8zm4.8 11.5L13 14.8l-3.1-3-3 3L5.1 13l3-3.1-3-3L7 5.1l3.1 3 3-3L14.9 7l-3 3.1 3 3z"></path></svg>
        </a>
    </div>
    <form class="ncforms-contact--form js-ncforms-contact-form">
        <div class="ncforms-contact--form--group">
            <label class="ncforms-contact--label">Type of your request</label>
            <select class="ncforms-contact--input"  name="type">
                <option value="feedback">Feedback</option>
                <option value="bug">Bug</option>
            </select>
        </div>
        <div class="ncforms-contact--form--group">
            <label class="ncforms-contact--label">Email</label>
            <input class="ncforms-contact--input" type="email" name="email">
        </div>
        <div class="ncforms-contact--form--group">
            <label class="ncforms-contact--label">Message</label>
            <textarea class="ncforms-contact--input" name="message"></textarea>
        </div>
        <?php if ($_GET['page'] == 'nocake-forms/page/form-builder.php') { ?>
            <div class="ncforms-contact--form--group">
                <input type="checkbox" name="attachForm" id="ncforms-contact-attach-form">
                <label class="ncforms-contact--label" for="ncforms-contact-attach-form" style="transform: translateY(-2px); display: inline-block">Attach current form to your request (it might help us to solve your problem)</label>
            </div>
        <?php } ?>
        <div class="ncforms-contact--form--group">
            <button class="ncforms-contact--send" type="submit">Send</button>
        </div>
    </form>
</div>