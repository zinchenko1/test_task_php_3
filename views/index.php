<?php
/**
 * @var $this View
 */
?>
<div class="container">
    <div class="row">
        <div class="col-xs-4"></div>
        <div class="col-xs-4">
            <form class="form-horizontal" method="POST" style="margin-top:10%;">
                <div class="row form-group field">
                    <label class="col-xs-4 control-label">Имя:</label>
                    <div class="col-xs-8">
                        <input type="text" name="name" class="form-control" placeholder="Введите имя" />
                    </div>
                    <span class="error"></span>
                </div>
                <div class="row form-group field">
                    <label class="col-xs-4 control-label">Телефон:</label>
                    <div class="col-xs-8">
                        <input type="tel" name="phone" class="form-control" placeholder="Ваш телефон" />
                    </div>
                    <span class="error"></span>
                </div>
                <div class="row form-group field">
                    <label class="col-xs-4 control-label">E-mail:</label>
                    <div class="col-xs-8">
                        <input type="email" name="email" class="form-control" placeholder="username@sitename.com" />
                    </div>
                    <span class="error"></span>
                </div>
                <div class="row form-group field">
                    <label class="col-xs-4 control-label">Комментарий:</label>
                    <div class="col-xs-8">
                        <textarea class="form-control" name="comment" rows="5" placeholder="Можно написать пару слов..."></textarea>
                    </div>
                    <span class="error"></span>
                    
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button class="btn btn-default pull-right form-submit" id="xxx">
                            Отправить
                        </button>
                    </div>
                </div>
            </form>
            <div class="thank-you">
                Спасибо!
            </div>
        </div>
        <div class="col-xs-4"></div>
    </div>
</div>
