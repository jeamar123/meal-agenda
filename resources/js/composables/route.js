export const useRoute = window.route

export const useQueryParam = () =>
  Object.fromEntries(new URLSearchParams(window.location.search).entries())

export const useUrlWithQuery = (route, query) =>
  `${route}?${new URLSearchParams(query).toString()}`

export const openToNewTab = (url) => {
  window.open(url, '_blank')
}
