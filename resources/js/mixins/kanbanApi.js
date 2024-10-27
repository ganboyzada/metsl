export default {
    
    methods: {
        add() {
            this.columns.push({
                title: "default",
                tasks: [{
                        id: 1,

                        title: "Design Dashboard",
                        date: "23/07/20",
                        badge: "medium",
                        badgetype: "badge-primary",
                        location: "Themeforest, australia",
                    },
                    {
                        id: 2,

                        title: "Test Sidebar",
                        date: "24/7/20",
                        badge: "Urgent",
                        badgetype: "badge-danger",
                        location: "Themeforest, australia",
                    },

                ]
            })
        },
        addelment() {
            this.columns[0].tasks.push({
                id: 1,
                title: "Design Dashboard",
                date: "23/07/20",
                badge: "medium",
                badgetype: "badge-primary",
                location: "Themeforest, australia",
            }, )
        },
        remove() {
            this.columns.forEach((element, index) => {
                if (element.title === 'Done') {
                    this.columns.splice(index, 1)
                }
            })
        }
    }
  }