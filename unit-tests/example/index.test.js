import { sumPure } from './index';
// import { sumPure, listItemsTpl } from './index';

// describe('impure function', () => {
//     it('adds 1 + 2 and returns 3', () => {
//         expect(sumImpure(1, 2)).toBe(3);
//         // expect(sumImpure(1, 2)).toBe(3); // Will fail
//     });
// })

describe('pure function', () => {
    it('adds 1 + 2 and returns 3', () => {
        expect(sumPure(1, 2)).toBe(3);
        expect(sumPure(1, 2)).toBe(3);
    });
})

// describe('listItemsTpl', () => {
//     const data = [
//         {name: "Chocolate"},
//         {name: "Speculoos"},
//         {name: "Almond"},
//         {name: "Vanilla"},
//         {title: "Strawberry"},
//     ]
//     it('return 4 items', () => {
//         expect(listItemsTpl(data)).toHaveLength(4);
//     });
// })


