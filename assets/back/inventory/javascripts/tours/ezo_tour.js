$(document).ready(function(){
  var title = getGlobalData('isAssetSonar') ? 'AssetSonar' : 'EZOfficeInventory'
  var tour = {
    id: 'ezo_tour',
    steps: [
      {
        title: "Welcome to " + title,
        content: "Click next for a guided tour. Or click x to end the tour. You can always pull it up later from the dashboard help section here.",
        target: "product-tour",
        placement: "left",
        yOffset: -10
      },
      {
        title: "Dashboard Overview",
        content: "This is your dashboard view. It gives you a snapshot view of your equipment usage.",
        target: document.querySelector(".icon-dashboard-black"),
        placement: "bottom"
      },
      {
        title: "Quickly see what's important",
        content: "Stay up to date with 'at glance metrics' and the 'calendar widget' so you can plan better for what's ahead.",
        target: document.querySelector(".ezo-tour-step-3"),
        placement: "right",
        yOffset: 80,
        arrowOffset: 50
      },
      {
        title: "Add new Items",
        content: "Action buttons are easy to access. Add new items to checkin or checkout in an instant.",
        target: document.querySelector(".ezo-tour-step-4"),
        placement: "left",
        yOffset: -30
      },
      {
        title: "Access items with a single click",
        content: "Access all your items from one place. Let's take a look at the items page.",
        target: document.querySelector(".icon-assets-black"),
        placement: "bottom",
        multipage: true,
        onNext: function() {
          $.cookie('productTourOngoing', 'true', { path: '/' });
          window.location = "/assets";
        }
      },
      {
        title: "Assets to checkout",
        content: "Unique items that are checked in or checked out individually are listed as Assets. These could be cameras, vehicles, laptops, etc.",
        target: document.querySelector(".ezo-tour-step-6"),
        placement: "bottom",
        onPrev: function() {
          $.cookie('productTourOngoing', 'true', { path: '/' });
          window.location = "/dashboard";
        }
      },
      {
        title: "Asset Stock to checkout",
        content: "Items that are tracked in bulk are listed as Asset Stock. These could be chairs, cables, nails, etc.",
        target: document.querySelector(".ezo-tour-step-7"),
        placement: "bottom"
      },
      {
        title: "Inventory to consume",
        content: "Items that are consumed are listed as Inventory. These could be water bottles, fuel, etc.",
        target: document.querySelector(".ezo-tour-step-8"),
        placement: "bottom"
      },
      {
        title: "Excel import",
        content: "Import items in bulk using Excel sheets.",
        target: document.querySelector(".ezo-tour-step-9"),
        placement: "left"
      },
      {
        title: "Bulk actions",
        content: "Select multiple items using checkboxes and take bulk actions with the Actions dropdown.",
        target: document.querySelector(".ezo-tour-step-10"),
        placement: "top"
      },
      {
        title: "Groups",
        content: "Use groups and subgroups to organize and categorize your items. For example, all Camera Lenses and Tripods can go to the Camera Accessories group.",
        target: document.querySelector(".ezo-tour-step-11"),
        placement: "bottom"
      },
      {
        title: "Locations",
        content: "Items can be tracked across locations. These can include rooms, warehouses or even cabinets. Locations will be shown on a map within this tab.",
        target: document.querySelector(".ezo-tour-step-12"),
        placement: "bottom"
      },
      {
        title: "Carts",
        content: "Add multiple items to carts for quick checkouts. Let's take a look.",
        target: document.querySelector(".icon-cart"),
        placement: "bottom",
        xOffset: -30,
        multipage: true,
        onNext: function() {
          $.cookie('productTourOngoing', 'true', { path: '/' });
          window.location = "/baskets/empty";
        }
      },
      {
        title: "Add to Cart",
        content: "Add items here for reservations or checkouts.",
        target: document.querySelector(".ezo-tour-step-14"),
        placement: "right",
        yOffset: -15,
        onPrev: function() {
          $.cookie('productTourOngoing', 'true', { path: '/' });
          window.location = "/assets";
        }
      },
      {
        title: "Members",
        content: "Your company staff is listed under Members, further categorized as Admins or Staff Users. Admins have full access, can add and update items, and run reports. Staff Users can be asset custodians but cannot add or update items.",
        target: document.querySelector('.icon-user-black'),
        placement: "bottom"
      },
      {
        title: "Add Custom Fields",
        content: "Items in " + title + " come with a predefined set of fields. You can also add custom fields to both Carts and Items from here.",
        target: document.querySelector(".ezo-tour-step-16"),
        placement: "left",
        yOffset: 10,
        arrowOffset: 25,
        delay: 500,
        onShow: function() {
          $('.ezo-tour-step-16').addClass('open');
        }
      },
      {
        title: "Settings, Add-Ons and Integrations",
        content: "Play around with advanced features here. Configure company settings (such as visibility, company logo, time zone, etc.) and enable integrations.",
        target: document.querySelector(".ezo-tour-step-17"),
        placement: "left",
        yOffset: 30,
        arrowOffset: 45,
        delay: 500,
        multipage: true,
        onShow: function() {
          $('.ezo-tour-step-17').addClass('open'); 
        },
        onNext: function() {
          $.cookie('productTourOngoing', 'true', { path: '/' });
          window.location = '/dashboard';
        }
      },
      {
        title: "Need more help?",
        content: "Need more help? See the full Getting Started Guide here.",
        target: document.querySelector(".ezo-tour-step-18"),
        placement: "left",
        yOffset: -10,
        delay: 500,
        onPrev: function() {
          $.cookie('productTourOngoing', 'true', { path: '/' });
          window.location = "/baskets/empty";
        }
      }
    ],
    showPrevButton: true,
    onEnd: function() {
      $.removeCookie("productTourOngoing", { path: '/' });
      hopscotch.endTour();
    },
    onClose: function() {
      $.removeCookie("productTourOngoing", { path: '/' });
      hopscotch.endTour();
    }
  };

  if($.cookie("productTourOngoing") != undefined){
    hopscotch.startTour(tour);
    $.removeCookie("productTourOngoing", { path: '/' });
  }
  else if (hopscotch.getCurrTour()) {
      hopscotch.endTour();
  }
  $('#product-tour').on('click', function(e){
    e.preventDefault();
    hopscotch.startTour(tour, 0);
  });
});