<template>
    <div>
        <Breadcrumbs main="UI Kits" title="Helper Classes" />

        <div class="container-fluid">
            <div class="row">
                <Padding />
                <Margins />
                <PaddingLeft />
                <PaddingRight />
                <PaddingTop />
                <PaddingBottom />
                <MarginLeft />
                <MarginRight />
                <MarginTop />
                <MarginBottom />
                <VerticalAlign />
                <ImageSizes />
                <TextColor />
                <BadgeColor />
                <BackgroundColor />
                <ButtonColor />

                <div class="col-md-6 col-sm-12">
                    <BorderRadius />
                    <FontWeight />
                    <FontStyle />
                    <Float />
                    <Overflow />
                </div>


                <FontSize></FontSize>
                <AllBordersColor />
                <div class="col-md-6 col-sm-12">
                    <BorderWidth />
                    <Position />
                    <ButtonOutline />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Padding from "./helperClass/Padding.vue"
import Margins from "./helperClass/Margins.vue";
import PaddingLeft from "./helperClass/PaddingLeft.vue"
import PaddingRight from "./helperClass/PaddingRight.vue";
import PaddingTop from "./helperClass/PaddingTop.vue";
import PaddingBottom from "./helperClass/PaddingBottom.vue";
import MarginLeft from "./helperClass/MarginLeft.vue";
import MarginRight from "./helperClass/MarginRight.vue";
import MarginTop from "./helperClass/MarginTop.vue";
import MarginBottom from "./helperClass/MarginBottom.vue";
import VerticalAlign from "./helperClass/VerticalAlign.vue"
import ImageSizes from "./helperClass/ImageSizes.vue";
import TextColor from "./helperClass/TextColor.vue";
import BadgeColor from "./helperClass/BadgeColor.vue";
import BackgroundColor from "./helperClass/BackgroundColor.vue";
import ButtonColor from "./helperClass/ButtonColor.vue";
import BorderRadius from "./helperClass/BorderRadius.vue";
import FontSize from "./helperClass/FontSize.vue";
import FontWeight from "./helperClass/FontWeight.vue";
import FontStyle from "./helperClass/FontStyle.vue";
import Float from "./helperClass/Float.vue";
import Overflow from "./helperClass/Overflow.vue";
import AllBordersColor from "./helperClass/AllBordersColor.vue";
import BorderWidth from "./helperClass/BorderWidth.vue";
import Position from "./helperClass/Position.vue";
import ButtonOutline from "./helperClass/ButtonOutline.vue";
export default {
    components: {
        Padding,
        Margins,
        PaddingLeft,
        PaddingRight,
        PaddingTop,
        PaddingBottom,
        MarginLeft,
        MarginRight,
        MarginTop,
        MarginBottom,
        VerticalAlign,
        ImageSizes,
        TextColor,
        BadgeColor,
        BackgroundColor,
        ButtonColor,
        BorderRadius,
        FontSize,
        FontWeight,
        FontStyle,
        Float,
        Overflow,
        AllBordersColor,
        BorderWidth,
        Position,
        ButtonOutline
    }
};
</script>
