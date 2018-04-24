import { sumImpure } from './index';

describe('impure function', () => {
    it('adds 1 + 2 and returns 3', () => {
        expect(sumImpure(1, 2)).toBe(3);
        // expect(sumImpure(1, 2)).toBe(3); // Will fail
    });
});
