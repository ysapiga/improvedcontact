require(['jquery'], function ($) {
        $('button#save').on('click', function () {
            element = $("<input type='submit' style='display: none' />").appendTo("form");
            element.click();
            element.remove();
        })
    }
);