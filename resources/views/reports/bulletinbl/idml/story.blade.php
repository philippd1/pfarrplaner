<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<idPkg:Story xmlns:idPkg="http://ns.adobe.com/AdobeInDesign/idml/1.0/packaging" DOMVersion="15.0">
    <Story Self="{{ $uid }}" UserText="true" IsEndnoteStory="false" AppliedTOCStyle="n" TrackChanges="false" StoryTitle="$ID/" AppliedNamedGrid="n">
        <StoryPreference OpticalMarginAlignment="false" OpticalMarginSize="12" FrameType="TextFrameType" StoryOrientation="Horizontal" StoryDirection="LeftToRightDirection" />
        <InCopyExportOption IncludeGraphicProxies="true" IncludeAllResources="false" />
        <ParagraphStyleRange AppliedParagraphStyle="ParagraphStyle/Tabelle_bold">
            <CharacterStyleRange AppliedCharacterStyle="CharacterStyle/grau">
                <Content>{{ $text }}</Content>
            </CharacterStyleRange>
        </ParagraphStyleRange>
    </Story>
</idPkg:Story>
