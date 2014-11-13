<?php
/**
 * Unit tests for run-route plugin.
 */
class RunRouteTest extends WP_UnitTestCase {

    // test that the shortcode is converted to the basic empty tag when written to a post
    public function test_create_and_get_empty_tag() {

        $expected = "<div class='run-route'></div>";

        $post = $this->factory->post->create_and_get(array('post_content' => '[run_route]'));
        $actual = apply_filters( 'the_content', $post->post_content );

        $this->assertEquals($expected, trim( $actual ));
    }

    // test that the shortcode is converted to the basic empty tag when calling apply_filters
    public function test_empty_tag() {

        $expected = "<div class='run-route'></div>";

        $actual = apply_filters( 'the_content', '[run_route]' );

        $this->assertEquals($expected, trim( $actual ));
    }

    public function test_endomondo_without_quotes() {

        $actual = apply_filters( 'the_content', '[run_route endomondo=123]' );

        $this->assertContains("<div class='run-route'>", $actual);
        $this->assertContains("<span class='endomondo'>", $actual);
        $this->assertContains("<a href='http://endomondo.com/routes/123'>", $actual);
        $this->assertContains("<img class='run-route-image'", $actual);
    }

    public function test_endomondo() {

        $actual = apply_filters( 'the_content', "[run_route endomondo='123']" );

        $this->assertContains("<div class='run-route'>", $actual);
        $this->assertContains("<span class='endomondo'>", $actual);
        $this->assertContains("<a href='http://endomondo.com/routes/123'>", $actual);
        $this->assertContains("<img class='run-route-image'", $actual);
        $this->assertNotContains("runkeeper", $actual);
    }

    // test that when runkeeper only user then it just shows empty tag
    public function test_rk_only_user() {

        $expected = "<div class='run-route'></div>";

        $actual = apply_filters( 'the_content', "[run_route rk_user='123']" );

        $this->assertEquals($expected, trim( $actual ));
    }

    // test that when runkeeper only route then it just shows empty tag
    public function test_rk_only_route() {

        $expected = "<div class='run-route'></div>";

        $actual = apply_filters( 'the_content', "[run_route rk_route='789']" );

        $this->assertEquals($expected, trim( $actual ));
    }

    public function test_runkeeper() {

        $actual = apply_filters( 'the_content', "[run_route rk_user='123' rk_route='789']" );

        $this->assertContains("<div class='run-route'>", $actual);
        $this->assertContains("<span class='runkeeper'>", $actual);
        $this->assertContains("<a href='http://runkeeper.com/user/123/route/789'>", $actual);
        $this->assertContains("<img class='run-route-image'", $actual);
        $this->assertNotContains("endomondo", $actual);
    }

    public function test_endomondo_and_runkeeper() {

        $actual = apply_filters( 'the_content', "[run_route endomondo='123' rk_user='123' rk_route='789']" );

        $this->assertContains("<div class='run-route'>", $actual);
        $this->assertContains("<span class='endomondo'>", $actual);
        $this->assertContains("<a href='http://endomondo.com/routes/123'>", $actual);
        $this->assertContains("<img class='run-route-image'", $actual);

        $this->assertContains("<div class='run-route'>", $actual);
        $this->assertContains("<span class='runkeeper'>", $actual);
        $this->assertContains("<a href='http://runkeeper.com/user/123/route/789'>", $actual);
        $this->assertContains("<img class='run-route-image'", $actual);
    }

}