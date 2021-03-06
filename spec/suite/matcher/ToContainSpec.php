<?php
namespace kahlan\spec\suite\matcher;

use stdClass;
use kahlan\spec\mock\Collection;
use kahlan\matcher\ToContain;

describe("toContain", function() {

    describe("::match()", function() {

        context("with an array", function() {

            it("passes if 3 is in [1, 2, 3]", function() {

                expect([1, 2, 3])->toContain(3);

            });

            it("passes if 'a' is in ['a', 'b', 'c']", function() {

                expect(['a', 'b', 'c'])->toContain('a');

            });

            it("passes if 'd' is in ['a', 'b', 'c']", function() {

                expect(['a', 'b', 'c'])->not->toContain('d');

            });

        });

        context("with a traversable instance", function() {

            it("passes if 3 is in [1, 2, 3]", function() {

                expect(new Collection(['data' => [1, 2, 3]]))->toContain(3);

            });

            it("passes if 'a' is in ['a', 'b', 'c']", function() {

                expect(new Collection(['data' => ['a', 'b', 'c']]))->toContain('a');

            });

            it("passes if 'd' is in ['a', 'b', 'c']", function() {

                expect(new Collection(['data' => ['a', 'b', 'c']]))->not->toContain('d');

            });

        });

        context("with a string", function() {

            it("passes if contained in expected", function() {

                expect('World')->toContain('Hello World!');
                expect('World')->toContain('World');

            });

            it("fails if not contained in expected", function() {

                expect('world')->not->toContain('Hello World!');

            });

        });

        it("fails with non string/array", function() {

            expect(new stdClass())->not->toContain('Hello World!');
            expect(false)->not->toContain('0');
            expect(true)->not->toContain('1');

        });

    });

    describe("::description()", function() {

        it("returns the description message", function() {

            $actual = ToContain::description();

            expect($actual)->toBe('contain expected.');

        });

    });

});
