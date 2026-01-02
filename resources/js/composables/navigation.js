export const useNavigation = () => {
  return {
    main: [
      {
        label: 'Home',
        route: 'meal.index',
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
        route: 'meal.index',
        component: 'PeoplePage',
        icon: 'UsersIcon',
      },
    ],
    secondary: [
      {
        label: 'Settings',
        route: 'meal.index',
        component: 'SettingsPage',
        icon: 'Cog6ToothIcon',
        divider: true,
      },
    ],
  }
}
