describe("Gallery Tests", function() {

  it("ContextObject isset", function() {
      expect(scanDir).toBeDefined();
  });

  it("scanDir.hashParse is a function", function() {
      expect(typeof scanDir.hashParse).toEqual('function');
  });
        

});
