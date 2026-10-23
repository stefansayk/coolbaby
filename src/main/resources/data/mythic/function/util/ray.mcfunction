# finds what the caster looks at (block or creature, up to 32 blocks) and leaves a marker tagged mythic.hit there
scoreboard players set @s mythic.steps 0
execute anchored eyes positioned ^ ^ ^1 run function mythic:util/ray_step
