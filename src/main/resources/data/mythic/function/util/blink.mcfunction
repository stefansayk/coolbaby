# steps forward in half blocks (max 8 blocks) until a wall, then teleports there
scoreboard players add @s mythic.steps 1
execute if score @s mythic.steps matches 17.. run return run tp @s ~ ~ ~
execute positioned ^ ^ ^0.5 if block ~ ~ ~ #mythic:passable if block ~ ~1 ~ #mythic:passable run return run function mythic:util/blink
tp @s ~ ~ ~
