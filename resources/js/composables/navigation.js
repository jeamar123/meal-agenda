export const useNavigation = () => {
  return {
    main: [
      {
        label: 'Home',
        route: 'calendar.index',
        component: 'Home',
        icon: 'HomeIcon',
      },
      {
        label: 'Recipes',
        route: 'recipes.index',
        component: 'RecipesPage',
        icon: 'BookOpenIcon',
      },
      {
        label: 'People',
        route: 'calendar.index',
        component: 'PeoplePage',
        icon: 'UsersIcon',
      },
    ],
    secondary: [
      {
        label: 'Settings',
        route: 'calendar.index',
        component: 'SettingsPage',
        icon: 'Cog6ToothIcon',
        divider: true,
      },
    ],
  }
}
