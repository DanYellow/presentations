import { sumPure, listItemsTpl } from './index';

describe('pure function', () => {
    it('adds 1 + 2 and returns 3', () => {
        expect(sumPure(1, 2)).toBe(3);
    });

    it('return 0', () => {
        expect(sumPure()).toBe(0);
    });
})

describe('listItemsTpl', () => {
    const data = [
        {name: "Chocolate"},
        {name: "Speculoos"},
        {name: "Almond"},
        {name: "Vanilla"},
        {title: "Strawberry"},
    ]
    it('return 4 items', () => {
        expect(listItemsTpl(data)).toHaveLength(4);
    });
})