export var menuItems={
  "data": [
    {
      "headTitle1": "General",
      "headTitle2": "Dashboards,Widgets & Layout.",
      "type": "headtitle"
    },
    {
      "title": "Dashboard",
      "icon": "stroke-home",
      "iconf":"fill-home",
      "type": "sub",
      "badgeType": "light-primary",
      "badgeValue": "5",
      "active": false,
      "children": [
        {
          "path": "/",
          "title": "Dashboard",
          "type": "link",
          "active":false
        },
        // {
        //   "path": "/dashboard/ecommerce",
        //   "title": "Ecommerce",
        //   "type": "link",
        //   "active":false
        // },
        // {
        //   "path": "/dashboard/online",
        //   "title": "Online Course",
        //   "type": "link",
        //   "active":false
        // },
        // {
        //   "path": "/dashboard/crypto",
        //   "title": "Crypto",
        //   "type": "link",
        //   "active":false
        // },
        // {
        //   "path": "/dashboard/social",
        //   "title": "Social",
        //   "type": "link",
        //   "active":false
        // }
      ]
    },
    // {
    //   "title": "Widgets",
    //   "icon": "stroke-widget",
    //   "iconf":"fill-widget",
    //   "type": "sub",
    //   "active": false,
    //   "children": [
    //     {
    //       "path": "/widgets/general",
    //       "title": "General",
    //       "type": "link",
    //       "active":false
    //     },
    //     {
    //       "path": "/widgets/chart",
    //       "title": "Chart",
    //       "type": "link",
    //       "active":false
    //     }
    //   ]
    // },
    // {
    //   "title": "Page Layout",
    //   "icon": "stroke-layout",
    //   "iconf":"fill-layout",
    //   "type": "sub",
    //   "active": false,
    //   "children": [
    //     {
    //       "path": "/pageLayout/boxed",
    //       "title": "Boxed",
    //       "type": "link",
    //       "active":false
    //     },
    //     {
    //       "path": "/pageLayout/RTL",
    //       "title": "RTL",
    //       "type": "link",
    //       "active":false
    //     },
    //     {
    //       "path": "/pageLayout/darklayout",
    //       "title": "Dark Layout",
    //       "type": "link",
    //       "active":false
    //     },
    //     {
    //       "path": "/pageLayout/hidenavscroll",
    //       "title": "Hide Nav Scroll",
    //       "type": "link",
    //       "active":false
    //     },
    //     {
    //       "path": "/pageLayout/footerlight",
    //       "title": "Footer Light",
    //       "type": "link",
    //       "active":false
    //     },
    //     {
    //       "path": "/pageLayout/footerdark",
    //       "title": "Footer Dark",
    //       "type": "link",
    //       "active":false
    //     },
    //     {
    //       "path": "/pageLayout/footerfixed",
    //       "title": "Footer Fixed",
    //       "type": "link",
    //       "active":false
    //     }
    //   ]
    // },
    {
      "headTitle1": "Applications",
      "headTitle2": "Ready to use apps",
      "type": "headtitle"
    },
    {
      "title": "project",
      "icon": "stroke-project",
      "iconf":"fill-project",
      "type": "sub",
      // "badgeType": "light-secondary",
      // "badgeValue": "New",
      "active": false,
      "children": [
        {
          "path": "/project/projectlist",
          "title": "Project list",
          "type": "link",
          "active": false
        },
        {
          "path": "/project/create-project",
          "title": "Create new",
          "type": "link",
          "active": false
        }
      ]
    },
    {
      "path": "/app/filemanager",
      "title": "File manager",
      "icon": "stroke-file",
      "iconf":"fill-file",
      "type": "link",
      "active": false
    },
    {
      "path": "/app/kanban",
      "title": "Kanban Board",
      "icon": "stroke-board",
      "iconf":"fill-board",
      "type": "link",
      // "badgeType": "light-danger",
      // "badgeValue": "Latest",
      "active": false
    },
    
    // {
      
    //   "title": "Email",
    //   "icon": "stroke-email",
    //   "iconf":"fill-email",
    //   "type": "sub",
    //   "active":false,
    //   "children": [
        
    //       {
    //         "path": "/email/readMail",
    //         "title" :"Email App",
    //         "type" : "link",
    //         "active":false
        
    //       },
    //       {
    //         "path": "/email/compose",
    //         "title" :"Email Compose",
    //         "type" : "link",
    //         "active":false
        
    //       }
    //   ]
    // },
    {
      "title": "chat",
      "icon": "stroke-chat",
      "iconf":"fill-chat",
      "type": "sub",
      "active": false,
      "children": [
        {
          "path": "/app/chat",
          "title": "Chat App",
          "type": "link",
          "active":false
        },
        {
          "path": "/app/videochat",
          "title": "Video Chat",
          "type": "link",
          "active":false
        }
      ]
    },
    {
      "title": "Users",
      "icon": "stroke-user",
      "iconf":"fill-user",
      "type": "sub",
      "active": false,
      "children": [
        {
          "path": "/users/profile",
          "title": "Users Profile",
          "type": "link",
          "active":false
        },
        {
          "path": "/users/edit",
          "title": "Users Edit",
          "type": "link",
          "active":false
        },
        {
          "path": "/users/cards",
          "title": "Users Cards",
          "type": "link",
          "active":false
        }
      ]
    },
    // {
    //   "path": "/app/bookmark",
    //   "title": "Bookmark",
    //   "icon": "stroke-bookmark",
    //   "iconf":"fill-bookmark",
    //   "type": "link",
    //   "bookmark": true
    // },
    {
      "path": "/app/contact",
      "title": "Contacts",
      "icon": "stroke-contact",
      "iconf":"fill-contact",
      "type": "link",
      "active": false

    },
    {
      "path": "/app/task",
      "title": "Tasks",
      "icon": "stroke-task",
      "iconf":"fill-task",
      "type": "link",
      "active": false
    },
    {
      "path": "/app/calendar",
      "title": "Calendar",
      "icon": "stroke-calendar",
      "iconf":"fill-calender",
      "type": "link",
      "active": false
    },
    // {
    //   "path": "/app/socialPage",
    //   "title": "Social App",
    //   "icon": "stroke-social",
    //   "iconf":"fill-social",
    //   "type": "link",
    //   "active": false
    // },
    {
      "path": "/app/todo",
      "title": "To-Do",
      "icon": "stroke-to-do",
      "iconf":"fill-to-do",
      "type": "link",
      "active": false
    },

  ]
}