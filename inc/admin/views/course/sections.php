<?php
/**
 * Template list sections.
 *
 * @since 3.0.0
 */

learn_press_admin_view( 'course/section' );
learn_press_admin_view( 'course/new-section' );
?>

<script type="text/x-template" id="tmpl-lp-list-sections">

    <div class="curriculum-sections">
        <draggable :list="sections" :options="{handle: '.movable'}" @end="updateSortSections">
            <lp-section v-for="(section, index) in sections"
                        :section="section" :index="index" :key="index"></lp-section>
        </draggable>

        <div class="add-new-section">
            <lp-new-section></lp-new-section>
        </div>
    </div>

</script>

<script type="text/javascript">
    (function (Vue, $store) {

        Vue.component('lp-list-sections', {
            template: '#tmpl-lp-list-sections',
            methods: {
                updateSortSections: function () {
                    var orders = [];
                    this.sections.forEach(function (section, index) {
                        orders.push(parseInt(section.id));
                    });

                    $store.dispatch('ss/updateSortSections', orders);
                }
            },
            computed: {
                sections: function () {
                    return $store.getters['ss/sections'];
                }
            }
        });
    })(Vue, LP_Curriculum_Store);
</script>