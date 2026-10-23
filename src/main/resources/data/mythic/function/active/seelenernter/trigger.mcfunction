# swap key pressed while holding Seelenernter
function mythic:util/swapback
tag @s add mythic.caster
execute if predicate mythic:sneaking run function mythic:active/seelenernter/try2
execute unless predicate mythic:sneaking run function mythic:active/seelenernter/try1
tag @s remove mythic.caster
