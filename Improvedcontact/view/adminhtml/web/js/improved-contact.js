require(['jquery'], function ($) {
        $('button#save').on('click', function () {
            var element = $("<input type='submit' style='display: none' />").appendTo("form");
            element.click();
            element.remove();
        })
    }
);