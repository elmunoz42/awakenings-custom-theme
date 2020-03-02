# Awakenings Wellness Center Custom Theme with Robust Integrations

Custom child theme that integrates customized templates and functionality leveraging Woocommerce, Appointments, Buddypress, Mailchimp and Events plugins with a robust front end "backend" Login page was also customized.

## Technology Stack Overview

#### Siteground

Hosting. 

#### Cloudflare 

Caching. If you are having caching issues set Cloudflare to Development Mode and Purge all Cache.

### Custom Plugin:

#### AWC Admin Theme: 
This customizes the wp-admin styling to simplify backend for certain types of users.

### Main Third Party Plugins and Usage:

#### IMPORTANT NOTE: PLUGINS HAVE BEEN "FROZEN" AT THEIR CURRENT VERSIONS DUE TO ALL THE INTEGRATIONS. THE NUMBER ONE PRIORITY IS TO GET THE WEBSITE FUNCTIONAL AND LAUNCHING. THE NUMBER TWO PRIORITY IS SEEING THAT THE PLUGINS CAN BE UPDATED AND FIX WHERE OVERRIDES CONFLICT WITH NEW PLUGIN VERSIONS. MODERN TRIBE's NEW EVENTS CALENDAR SEEMS TO BE QUITE DIFFERENT THAN THE CURRENT VERSION USE YOUR JUDGEMENT ON HOW TO PROCEED. A REASONABLE STRATEGY MIGHT BE TO LAUNCH AFTER QA AND THEN DO A POST LAUNCH SPRINT TO UPDATE PLUGINS AND OVERRIDES IN A DEV ENVIRONMENT THEN LIVE.

#### Woocommerce and extensions:

e-commerce functionality. 
Please note that the Woo "Products" tab in the dashboard has been renamed to "Offerings". Note also that we were experimenting with the Product Vendor functionality, but its not necessary to meet the specs. If we are to use it each therapist would be a vendor of their own appointment product. The product vendor extension allows for direct disbursement of funds through paypal. If this becomes to cumbersome a simple alternative could be to have a link/button to each therapists paypal account. My understanding is that Awakenings is not trying to take a commission from the appointment transactions because each therapist is already paying rent for their therapy room for that day. The goal here is convenience for the therapist and client. That being said lets make sure the events calendar disbursement through Paypal is working first (see below) before we try to do that here. Vendor Product is currently setup although not fully integrated (working) with Paypal Mass Payment yet, so this needs to either be fixed or simplified to simple Paypal links to therepists.

#### Woocommerce Appointments (This plugin is not from Automatic):

Appointment functionality that integrates with woocommerce.
Each therapist should be their own appointment product. When a user goes to that product they can choose a time for their appointment. Therapists when logging into their dashboard can set their availability, it could even be setup to sync with their Google Calendars but I never got around to fully making that integration. I would say that is extra.

#### Buddypress:

Utilized primarily for member page

#### BBPress:

Forum for the Therapists and admins. 

#### Modern Tribe Events Calendar and extensions:

Utilized mainly for booking the studio.

#### Events Calendar integration with Woocommerce:

The idea is that potential event hosts can submit a potential event to host at the Awakenings Studio. 
The studio administrator from the /dashboard-administrator page see's the request, checks studio availability and creates an order in the woocommerce backend (links are in the dashboard). 

The woocommerce order page has been customized so that a contract can be created with default (but customizable) language. If the event is part of a series all the instances of the event can have a woocommerce order automatically created for them. When you email the invoice the language will reflect all this with links to pay the deposit, remainder and installments for the different instances of the event. Meta data filled out in this order page gets saved to the events posts themselves which is used for example to show the access and eggress time on the admin calendar /events-with-dashboard-button .

A cron job has been created to send event hosts a reminder email/invoice some number of days before their event to pay their fees.

Events can have ticket sales and rsvps. The events calendar community events tickets functionality is supposed to disburse tickets according to a commission set in the events calendar settings. This integration is almost setup. Don't be confused with the "Commission" tab in the wordpress dashboard that is for the woocommerce product vendor extension.


#### Nextend Social Login:

Used for social login. 
Currently the Facebook account is linked to Carlos' personal account. This should be switched over to an Awakenings account.
We also want Google login functionality setup.

#### Contact Form 7 and Flamingo:

Used for contacts forms and keeping contacts.

#### User Role Editor 

To customize user roles.

### Other integrations

#### rss.php

Mailchimp is integrated with the custom rss.php feed allowing mailchimp to send an automated newsletter each month with upcoming events.

#### functions.php

Functionality that accomplishes tasks accross different plugins is located in the functions.php file. 

#### template overrides

A few templates have been overriden from various plugins.

#### Front end dashboards

Dashboards are created with regular wordpress pages. The if menu plugin displays the right dashboard to the right user role. Also, certain users are redirected to their respective dashboard upon login. Customers and subscribers are not redirected to their dashboards because they might be logging in to RSVP to an event and we don't want to send them away from the task they were trying to accomplish. Shortcodes from plugins are leveraged here BUT ALSO CUSTOM SHORTCODES that are in the functions.php file. 

#### Testimonials Are a Custom Post Type

in the client dashboard /dashboard-client/ there is a custom front end form to create a testimonial post.

#### Articles front end form

The therapists have a front end form they can use to create wordpress posts. They have access to this from their /dashboard-therapist/ page. There is also a post category for room openings. The therapists at Awakenings rent their rooms for certain days when they want to give a day up they can post about it. This appears on the home page.

## General Functionality QA Specs

See spreadsheet:
https://docs.google.com/spreadsheets/d/1jdeni7ChcHQon7P7otxzJp_inHHqB3PFlKRTH8ThlXU/edit?usp=sharing







