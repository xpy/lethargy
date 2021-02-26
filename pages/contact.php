<div id="contact" class="page page4">

    <form action="#" onsubmit="return false;" id="contact-form" target="_blank" method="post"
          enctype="application/x-www-form-urlencoded">
        <div class="input-holder">
            <div class="fakeInput" id="contact-exp">
                <table>
                    <tr>
                        <td>
                            <div class="required">Required / Invalid</div>
                        </td>
                        <td>
                            <div class="valid">Valid</div>
                        </td>
                        <td>
                            <div class="optional">Optional</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="input-holder">
            <input type="text" pattern="([a-z]|[A-Z]|[ ])*" id="name" placeholder="Name" required name="name">
            <label for="name" data-value="Name">N</label>
        </div>
        <div class="input-holder">
            <input type="email" id="mail" placeholder="e-mail" required name="mail">
            <label for="mail" data-value="e-mail" style="line-height: 25px;">@</label>
        </div>
        <div class="input-holder">
            <input type="url" id="site" placeholder="Site" optional name="site">
            <label for="site" data-value="Personal Site">&</label>
        </div>
        <div class="input-holder">
            <input type="text" id="subject" placeholder="Subject" optional pattern=".*" name="subject">
            <label for="subject" data-value="Subject">?</label>
        </div>
        <div class="input-holder" >
            <textarea rows="6" cols="5" placeholder="Text" id="text" required name="text"style="height: auto; "></textarea>
            <label for="text" data-value="text">T</label>
        </div>
        <div class="input-holder">
            <div class="fakeInput" id="stars">
                <?php for ($i = 5; $i > 0; $i--) { ?>
                <input type="radio" id="star_<?=$i;?>" autocomplete="off" name="stars_radio" value="<?=$i;?>"><label
                    class="star" for="star_<?=$i;?>"></label>
                <? } ?>
                <label class="optional contact-info" data-value="Rate This Site">R</label>
            </div>
        </div>
        <input type="submit" value="Submit Form" name="submit">
    </form>
        <div class="plainPage" style="text-align: center; width:100%;">
            <h2 class="lined">Stalk me - Stalk you</h2>
            <div id="socials">
                <div class="social">
                    <div class="notice">
                        <div class="notice-inside">
                            Temporarily Idle
                        </div>
                    </div>
                    <a id="deviant" href="http://pachryso.deviantart.com" class="social-link"></a>
                </div>
                <div class="social">
                    <div class="notice">
                        <div class="notice-inside">
                            Spectator
                        </div>
                    </div>
                    <a id="twitter" href="http://twitter.com/PavlosChri" class="social-link"></a>
                </div>
                <div class="social">
                    <div class="notice">
                        <div class="notice-inside">
                            Classic Stalker
                        </div>
                    </div>
                    <a id="fb" href="http://www.facebook.com/pavloschris" class="social-link"></a>

                </div>
                <div class="social">
                    <div class="notice">
                        <div class="notice-inside">
                            Procrastinating
                        </div>
                    </div>
                    <a id="git" href="http://github.com/xpy" class="social-link"></a>

                </div>
                <div class="social">
                    <div class="notice">
                        <div class="notice-inside" style="width:230px;">
                            setInterval( checkMail, 120000 );
                        </div>
                    </div>
                    <a id="mailLink" href="mailto:pavloschris@gmail.com" class="social-link"></a>
                </div>
            </div>
        </div>
</div>