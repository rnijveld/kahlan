<?php
namespace spec;

use kahlan\Suite;
use kahlan\Matcher;

describe("Suite", function() {

    beforeEach(function() {
        $this->suite = new Suite(['matcher' => new Matcher()]);
    });

    describe("before", function() {

        $nb = 0;

        before(function() use (&$nb) {
            $nb++;
        });

        it("passes if `before` has been executed", function() use (&$nb) {
            expect($nb)->toBe(1);
        });

        it("passes if `before` has not been executed twice", function() use (&$nb) {
            expect($nb)->toBe(1);
        });

    });

    describe("beforeEach", function() {

        $nb = 0;

        beforeEach(function() use (&$nb) {
            $nb++;
        });

        it("passes if `beforeEach` has been executed", function() use (&$nb) {
            expect($nb)->toBe(1);
        });

        it("passes if `beforeEach` has been executed twice", function() use (&$nb) {
            expect($nb)->toBe(2);
        });

        context("with sub scope", function() use (&$nb) {

            it("passes if `beforeEach` has been executed once more", function() use (&$nb) {
                expect($nb)->toBe(3);
            });

        });

        it("passes if `beforeEach` has been executed once more", function() use (&$nb) {
            expect($nb)->toBe(4);
        });

    });

    describe("after", function() {

        $nb = 0;

        after(function() use (&$nb) {
            $nb++;
        });

        it("passes if `after` has not been executed", function() use (&$nb) {
            expect($nb)->toBe(0);
        });

    });

    describe("afterEach", function() {

        $nb = 0;

        afterEach(function() use (&$nb) {
            $nb++;
        });

        it("passes if `afterEach` has not been executed", function() use (&$nb) {
            expect($nb)->toBe(0);
        });

        it("passes if `afterEach` has been executed", function() use (&$nb) {
            expect($nb)->toBe(1);
        });

        context("with sub scope", function() use (&$nb) {

            it("passes if `afterEach` has been executed once more", function() use (&$nb) {
                expect($nb)->toBe(2);
            });

        });

        it("passes if `afterEach` has been executed once more", function() use (&$nb) {
            expect($nb)->toBe(3);
        });

    });

    describe("xdescribe", function() {

        it("executes only the exclusive `it`", function() {

            $describe = $this->suite->describe("", function() {

                $this->exectuted = [];

                $this->xdescribe("xdescribe", function() {

                    $this->it("xdescribe it", function() {
                        $this->exectuted['xit']++;
                    });

                    $this->it("xdescribe it", function() {
                        $this->exectuted['xit']++;
                    });

                });

                $this->describe("describe", function() {

                    $this->it("describe it", function() {
                        $this->exectuted['it']++;
                    });

                    $this->it("describe it", function() {
                        $this->exectuted['it']++;
                    });

                });

            });

            $this->suite->run();

            expect($describe->exectuted)->toEqual(['xit' => 2]);
            expect($this->suite->exclusive())->toBe(true);
            expect($this->suite->status())->toBe(-1);

        });

    });

    describe("xcontext", function() {

        it("executes only the exclusive `it`", function() {

            $describe = $this->suite->describe("", function() {

                $this->exectuted = [];

                $this->xcontext("xcontext", function() {

                    $this->it("xcontext it", function() {
                        $this->exectuted['xit']++;
                    });

                    $this->it("xcontext it", function() {
                        $this->exectuted['xit']++;
                    });

                });

                $this->context("context", function() {

                    $this->it("context it", function() {
                        $this->exectuted['it']++;
                    });

                    $this->it("context it", function() {
                        $this->exectuted['it']++;
                    });

                });

            });

            $this->suite->run();

            expect($describe->exectuted)->toEqual(['xit' => 2]);
            expect($this->suite->exclusive())->toBe(true);
            expect($this->suite->status())->toBe(-1);

        });

    });

    describe("xit", function() {

        it("executes only the exclusive `it`", function() {

            $describe = $this->suite->describe("", function() {

                $this->exectuted = [];

                $this->it("an it", function() {
                    $this->exectuted['it']++;
                });

                $this->xit("an xit", function() {
                    $this->exectuted['xit']++;
                });

                $this->it("an it", function() {
                    $this->exectuted['it']++;
                });

                $this->xit("an xit", function() {
                    $this->exectuted['xit']++;
                });

            });

            $this->suite->run();

            expect($describe->exectuted)->toEqual(['xit' => 2]);
            expect($this->suite->exclusive())->toBe(true);
            expect($this->suite->status())->toBe(-1);

        });

    });

});

?>