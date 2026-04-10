export default function fluidType(minViewport, maxViewport, minValue, maxValue) {
    const clean = (str) => str.toString().trim().replace(/['"]/g, '');

    const minVw = clean(minViewport);
    const maxVw = clean(maxViewport);
    const minVal = clean(minValue);
    const maxVal = clean(maxValue);

    const minNum = parseFloat(minVal);
    const maxNum = parseFloat(maxVal);
    const minVwNum = parseFloat(minVw);
    const maxVwNum = parseFloat(maxVw);

    const minUnit = minVal.replace(minNum, '');
    const maxUnit = maxVal.replace(maxNum, '');

    const preferred = `calc(${minVal} + (${maxNum} - ${minNum}) * (100vw - ${minVw}) / (${maxVwNum} - ${minVwNum}))`;
    const clampMin = minNum <= maxNum ? minVal : maxVal;
    const clampMax = minNum <= maxNum ? maxVal : minVal;

    if (minUnit === '%' && maxUnit === '%') {
        const difference = maxNum - minNum;
        const preferredPercent = `calc(${minVal} + (${difference}) * (100vw - ${minVw}) / (${maxVwNum} - ${minVwNum}))`;

        return `clamp(${clampMin}, ${preferredPercent}, ${clampMax})`;
    }

    return `clamp(${clampMin}, ${preferred}, ${clampMax})`;
}