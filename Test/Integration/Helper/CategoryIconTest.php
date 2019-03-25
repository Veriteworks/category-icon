<?php

namespace MageSuite\CategoryIcon\Test\Integration\Helper;

/**
 * @magentoDbIsolation enabled
 * @magentoAppIsolation enabled
 */
class CategoryIconTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Magento\Catalog\Api\CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var \MageSuite\CategoryIcon\Helper\CategoryIcon
     */
    protected $categoryHelper;

    public function setUp()
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->categoryHelper = $this->objectManager->get(\MageSuite\CategoryIcon\Helper\CategoryIcon::class);
        $this->categoryRepository = $this->objectManager->create(\Magento\Catalog\Api\CategoryRepositoryInterface::class);
    }

    public static function loadCategoriesFixture()
    {
        require __DIR__.'/../_files/categories.php';
    }

    public static function loadCategoriesFixtureRollback()
    {
        require __DIR__.'/../_files/categories_rollback.php';
    }

    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture loadCategoriesFixture
     */
    public function testItReturnsCategoryIcon()
    {
        $categoryId = 335;

        $category = $this->categoryRepository->get($categoryId);

        $this->assertEquals('icon.png', $category->getCategoryIcon());
        $this->assertEquals(
            'http://localhost/pub/media/catalog/category/icon.png',
            $this->categoryHelper->getUrl($category)
        );
    }
}