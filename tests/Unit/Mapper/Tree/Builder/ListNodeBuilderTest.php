<?php

declare(strict_types=1);

namespace CuyZ\Valinor\Tests\Unit\Mapper\Tree\Builder;

use AssertionError;
use CuyZ\Valinor\Mapper\Tree\Builder\ListNodeBuilder;
use CuyZ\Valinor\Mapper\Tree\Builder\RootNodeBuilder;
use CuyZ\Valinor\Mapper\Tree\Exception\SourceMustBeIterable;
use CuyZ\Valinor\Mapper\Tree\Shell;
use CuyZ\Valinor\Tests\Fake\Type\FakeType;
use CuyZ\Valinor\Type\Types\ListType;
use PHPUnit\Framework\TestCase;

final class ListNodeBuilderTest extends TestCase
{
    public function test_build_with_null_value_returns_empty_branch_node(): void
    {
        $node = (new RootNodeBuilder(new ListNodeBuilder()))->build(Shell::root(ListType::native(), null));

        self::assertSame([], $node->value());
        self::assertEmpty($node->children());
    }

    public function test_invalid_type_fails_assertion(): void
    {
        $this->expectException(AssertionError::class);

        (new RootNodeBuilder(new ListNodeBuilder()))->build(Shell::root(new FakeType(), []));
    }

    public function test_build_with_invalid_source_throws_exception(): void
    {
        $this->expectException(SourceMustBeIterable::class);
        $this->expectExceptionCode(1618739163);
        $this->expectExceptionMessage('Source must be iterable in order to be cast to `list`, but is of type `string`.');

        (new RootNodeBuilder(new ListNodeBuilder()))->build(Shell::root(ListType::native(), 'foo'));
    }
}
