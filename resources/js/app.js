
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });

var notifications = [];

const NOTIFICATION_TYPES = {
    AssignedTicket: 'App\\Notifications\\AssignedTicket'
};

$(document).ready(function() {
    // check if there's a logged in user
    if(Laravel.userId) {
        $.get('/notifications', function (data) {
            addNotifications(data, "#notifications");
        });
    }
});

function addNotifications(newNotifications, target) {
    notifications = _.concat(notifications, newNotifications);
    // show only last 5 notifications
    notifications.slice(0, 5);
    showNotifications(notifications, target);
}

function showNotifications(notifications, target) {
    if(notifications.length) {
        var htmlElements = notifications.map(function (notification) {
            return makeNotification(notification);
        });
        $(target + 'Menu').html(htmlElements.join(''));
        $(target).addClass('has-notifications')
        document.getElementById('heartbit').style.display = "block";
        document.getElementById('point').style.display = "block";
    } else {
        $(target + 'Menu').html('<ul><li><h5 class="drop-title-notify">No notifications</h5></li></ul>');
        $(target).removeClass('has-notifications');
    }
}

// Make a single notification string
function makeNotification(notification) {
    var to = routeNotification(notification);
    var notificationText = makeNotificationText(notification);
    return '<li class="drop-title-notify-list"><a href="' + to + '">' + notificationText + '</a></li>';
}

// get the notification route based on it's type
function routeNotification(notification) {
    var to = '?read=' + notification.id;
    const ticket_id = notification.data.ticket_id;
    if(notification.type === NOTIFICATION_TYPES.AssignedTicket) {
        to = 'users' + to;
    }
    return '/ticket/' + ticket_id + to;
}

// get the notification text based on it's type
function makeNotificationText(notification) {
    var text = '';
    if(notification.type === NOTIFICATION_TYPES.AssignedTicket) {
        const ticket_title = notification.data.ticket_title;
        const ticket_id = notification.data.ticket_id;
        text += '<div class="mail-contnet"><h5>Ticket #'+ ticket_id +' assgined</h5><span class="notify-box-title">'+ ticket_title +'</span></div>';
    }
    return text;
}

$(document).ready(function() {
    if(Laravel.userId) {
        //...
        window.Echo.private(`App.User.${Laravel.userId}`)
            .notification((notification) => {
                addNotifications([notification], '#notifications');
                // console.log(notification.data.name);
                // alert(JSON.stringify(notification.data.name));
            });
    }
});