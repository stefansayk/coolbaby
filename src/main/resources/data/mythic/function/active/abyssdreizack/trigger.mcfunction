# swap key pressed while holding Abyss-Dreizack
function mythic:util/swapback
tag @s add mythic.caster
execute if predicate mythic:sneaking run function mythic:active/abyssdreizack/try2
execute unless predicate mythic:sneaking run function mythic:active/abyssdreizack/try1
tag @s remove mythic.caster
