import { sumPure } from './index';

// describe('impure function', () => {
//     xit('adds 1 + 2 and returns 3', () => {
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
