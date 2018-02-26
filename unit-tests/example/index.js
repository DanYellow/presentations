export const sumPure = (a = 0, b = 0) => {
    return a + b;
}

// let a = 2;
// export const sumImpure = (b) => {
//     a = a + b;
//     return a
// }

// export const listItemsTpl = (apiRes) => (
//     apiRes
//         .filter(entry => entry.name)
//         .map(entry => {
//             return `<li>${entry.name}</li>`
//     })
//  )