<?php
/**
 * Unit tests for run-route plugin.
 */
class RunRouteTest extends WP_UnitTestCase {

    // test that the shortcode is converted to the basic empty tag when written to a post
    public function test_create_and_get_empty_tag() {
        // http://codesymphony.co/writing-wordpress-plugin-unit-tests/

        $expected = <<<EOF
<div class='run-route'></div>
EOF;

        // $post will be an instance of WP_Post
        $post = $this->factory->post->create_and_get(array('post_content' => '[run_route page=1]'));
        $actual = apply_filters( 'the_content', $post->post_content );

        $this->assertEquals($expected, trim( $actual ));
    }

    // test that the shortcode is converted to the basic empty tag when calling apply_filters
    public function test_empty_tag() {
        // http://codesymphony.co/writing-wordpress-plugin-unit-tests/

        $expected = <<<EOF
<div class='run-route'></div>
EOF;

        // $post will be an instance of WP_Post
        $actual = apply_filters( 'the_content', '[run_route page=1]' );

        $this->assertEquals($expected, trim( $actual ));
    }
}