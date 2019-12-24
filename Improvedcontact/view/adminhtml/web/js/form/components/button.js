/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * @api
 */
define([
    'Magento_Ui/js/form/components/button',
], function (Button) {
    'use strict';

    return Button.extend({
        defaults: {
            template: 'ui/form/components/button/container',
            title: 'Reply on message',
        },
    });
});