export const objToURLParams = (obj) => {
  return Object.entries(obj)
    .map(([key, val]) => `${key}=${val}`)
    .join('&')
}

export const getNestedObjectValue = (obj, key) => {
  // Method for accessing nested objects by string path
  // e.g( object['booking.event'] )

  // Usage: getNestedObjectValue(object, 'booking.event')

  if (obj === undefined) {
    return
  }

  key = key.replace(/\[(\w+)\]/g, '.$1') // Convert indexes to properties
  key = key.replace(/^\./, '') // Strip a leading dot
  const keys = key.split('.')
  for (let i = 0, n = keys.length; i < n; ++i) {
    const k = keys[i]
    if (k in obj) {
      obj = obj[k]
    } else {
      return
    }
  }
  return obj
}

export const arraysAreEqualUsingJSON = (arr1, arr2) => {
  const json1 = JSON.stringify(arr1)
  const json2 = JSON.stringify(arr2)

  return json1 === json2
}
